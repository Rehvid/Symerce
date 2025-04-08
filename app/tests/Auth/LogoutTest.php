<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutTest extends ApiTestCase
{
    public function testLogoutSuccessfullyLogoutUser(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_GET, '/api/auth/logout');
        $response = $this->client->getResponse();
        $data = $this->getJsonResponseData();

        $this->assertArrayHasKey('success', $data);
        $this->assertResponseNotHasCookie('BEARER');
        $this->assertJsonResponse($response, Response::HTTP_OK);
    }
}
