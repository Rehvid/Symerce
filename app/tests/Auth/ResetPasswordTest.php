<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Admin\Infrastructure\Repository\UserTokenRepository;
use App\DTO\Admin\Request\UserToken\StoreUserTokenRequestDTO;
use App\Entity\UserToken;
use App\Enums\TokenType;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Persisters\Admin\UserToken\UserTokenCreatePersister;
use App\Tests\ApiTestCase;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordTest extends ApiTestCase
{
    public function testSuccessfulResetPassword(): void
    {
        $user = $this->createUser();

        $persist = PersistableDTOFactory::create(StoreUserTokenRequestDTO::class, [
            'user' => $user,
            'token' => Guid::uuid4()->toString(),
            'tokenType' => TokenType::FORGOT_PASSWORD,
            'expiresAt' => (new \DateTime())->add(new \DateInterval('PT1H')),
        ]);

        $createUserTokenPersister = static::getContainer()->get(UserTokenCreatePersister::class);
        $userTokenEntity = $createUserTokenPersister->persist($persist);

        /** @var UserToken $userToken */
        $userToken = static::getContainer()->get(UserTokenRepository::class)->find($userTokenEntity->getId());
        $this->assertNotNull($userToken);

        $this->sendJsonRequest(Request::METHOD_PUT, "api/auth/{$userToken->getToken()}/reset-password", [
            'password' => self::DEFAULT_USER_PASSWORD,
            'passwordConfirmation' => self::DEFAULT_USER_PASSWORD,
        ]);

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/login', [
            'email' => $user->getEmail(),
            'password' => self::DEFAULT_USER_PASSWORD,
        ]);

        $response = $client->getResponse();
        $this->assertJsonResponse($response, Response::HTTP_OK);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);

        $this->assertArrayHasKey('user', $data['data']);
        $this->assertArrayHasKey('email', $data['data']['user']);
        $this->assertEquals($user->getEmail(), $data['data']['user']['email']);
    }

    public function testFailedResetPassword(): void
    {
        $token = Guid::uuid4()->toString();
        $this->sendJsonRequest(Request::METHOD_PUT, "api/auth/{$token}/reset-password", [
            'password' => self::DEFAULT_USER_PASSWORD,
            'passwordConfirmation' => self::DEFAULT_USER_PASSWORD,
        ]);

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_NOT_FOUND);
    }
}
