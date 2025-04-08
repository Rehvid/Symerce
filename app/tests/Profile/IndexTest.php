<?php

declare(strict_types=1);

namespace App\Tests\Profile;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends ApiTestCase
{
    public function testPersonalSuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_GET, "/api/admin/profiles/{$user->getId()}");

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $this->assertArrayHasKey('firstname', $data['data']['user']);
        $this->assertArrayHasKey('surname', $data['data']['user']);
        $this->assertArrayHasKey('email', $data['data']['user']);
        $this->assertArrayHasKey('fullName', $data['data']['user']);
    }

    public function testPersonalFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_GET, "/api/admin/profiles/0");

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
