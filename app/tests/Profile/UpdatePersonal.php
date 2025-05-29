<?php

declare(strict_types=1);

namespace App\Tests\Profile;

use App\Tests\ApiTestCase;
use App\User\Infrastructure\Repository\UserDoctrineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdatePersonal extends ApiTestCase
{
    public function testUpdatePersonalSuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(
            Request::METHOD_PUT,
            "/api/admin/profiles/{$user->getId()}/personal",
            [
                'firstname' => 'LocalHost',
                'surname' => $user->getSurname(),
                'email' => $user->getUserIdentifier(),
                'fullName' => $user->getFullName(),
            ]
        );

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $userEntity = self::getContainer()->get(UserDoctrineRepository::class)->find($user->getId());
        $this->assertNotNull($userEntity);

        $this->assertSame($user->getFullName(), 'LocalHost');
    }

    public function testUpdatePersonalFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(
            Request::METHOD_PUT,
            "/api/admin/profiles/{$user->getId()}/personal",
            [
                'surname' => $user->getSurname(),
                'email' => $user->getUserIdentifier(),
                'fullName' => $user->getFullName(),
            ]
        );

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
