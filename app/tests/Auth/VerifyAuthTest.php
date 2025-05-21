<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Admin\Domain\Entity\User;
use App\Tests\ApiTestCase;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAuthTest extends ApiTestCase
{
    private JWTTokenManagerInterface $tokenManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenManager = self::getContainer()->get(JWTTokenManagerInterface::class);
    }

    public function testVerifyReturnsUserSessionWhenTokenIsValid(): void
    {
        $user = $this->createUser();

        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);
        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/verify');

        $this->assertResponseIsSuccessful();
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertArrayHasKey('user', $data['data']);
        $this->assertSame($user->getEmail(), $data['data']['user']['email']);
    }

    public function testVerifyReturnsUnauthorizedWhenTokenMissing(): void
    {
        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/verify');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertArrayNotHasKey('user', $data['data']);
        $this->assertSame('Token not found', $data['errors']['message']);
    }

    public function testVerifyReturnsUnauthorizedWhenTokenIsInvalid(): void
    {
        $this->client->getCookieJar()->set(new Cookie('BEARER', 'invalid.token.value'));
        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/verify');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertArrayNotHasKey('user', $data['data']);
        $this->assertStringContainsString('Could not parse token', $data['errors']['message']);
    }

    public function testVerifyReturnsUnauthorizedWhenTokenExpired(): void
    {
        $user = $this->createUser();

        $expiredToken = $this->tokenManager->createFromPayload($user, [
            'username' => $user->getUserIdentifier(),
            'exp' => time() - 3600,
        ]);

        $this->client->getCookieJar()->set(new Cookie('BEARER', $expiredToken));
        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/verify');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertArrayNotHasKey('user', $data['data']);
        $this->assertSame('Could not parse token. Expired JWT Token', $data['errors']['message']);
    }

    public function testVerifyReturnsUnauthorizedWhenUserNotFound(): void
    {
        $user = new User();
        $user->setEmail('ghost@example.com');
        $user->setFirstname('Ghost');
        $user->setSurname('User');
        $user->setRoles(['ROLE_USER']);

        $token = $this->tokenManager->createFromPayload($user, [
            'username' => 'ghost@example.com',
            'exp' => time() + 3600,
        ]);

        $this->client->getCookieJar()->set(new Cookie('BEARER', $token));
        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/verify');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertArrayNotHasKey('user', $data['data']);
        $this->assertSame('User not found', $data['errors']['message']);
    }
}
