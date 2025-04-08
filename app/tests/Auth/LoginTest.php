<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends ApiTestCase
{

    public function testSuccessfulLogin(): void
    {
        $user = $this->createUser();

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

    public function testLoginWithInvalidPassword(): void
    {
        $user = $this->createUser();

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/login', [
            'email' => $user->getEmail(),
            'password' => 'WrongPassword!',
        ]);

        $response = $client->getResponse();
        $this->assertJsonResponse($response, Response::HTTP_UNAUTHORIZED);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
    }
}
