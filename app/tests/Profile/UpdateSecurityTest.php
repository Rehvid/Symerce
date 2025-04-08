<?php

declare(strict_types=1);

namespace App\Tests\Profile;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateSecurityTest extends ApiTestCase
{
    public function testUpdateSecuritySuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(
            Request::METHOD_PUT,
            "/api/admin/profiles/{$user->getId()}/security",
            [
                'password' => 'NewPassword123$',
                'passwordConfirmation' => 'NewPassword123$'
            ]
        );

        $this->assertIsApiResponse($this->getJsonResponseData());
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/logout');
        $response = $this->client->getResponse();
        $data = $this->getJsonResponseData();

        $this->assertArrayHasKey('success', $data);
        $this->assertResponseNotHasCookie('BEARER');
        $this->assertJsonResponse($response, Response::HTTP_OK);

        $this->login($user->getEmail(), 'NewPassword123$');
    }

    public function testUpdateSecurityFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(
            Request::METHOD_PUT,
            "/api/admin/profiles/{$user->getId()}/security",
            [
                'password' => 'NewPassword$',
                'passwordConfirmation' => 'NewPassword$'
            ]
        );

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
