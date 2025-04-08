<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ForgetPasswordTest extends ApiTestCase
{

    public function testForgotPasswordSuccessfully(): void
    {
        $user = $this->createUser();
        $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/forgot-password', ['email' => $user->getEmail()]);

        $this->assertResponseIsSuccessful();
        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
    }

    public function testForgotPasswordFailed(): void
    {
        $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/forgot-password', ['email' => 'localHost@host.com']);


        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
