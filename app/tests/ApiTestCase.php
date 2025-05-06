<?php

declare(strict_types=1);

namespace App\Tests;

use App\DTO\Admin\Request\User\StoreRegisterUserRequestDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\DataPersister\Persisters\Admin\User\UserRegisterCreatePersister;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected const string DEFAULT_USER_PASSWORD = 'Password123$';


    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function getJsonResponseData()
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }

    protected function sendJsonRequest(string $method, string $uri, array $data = []): KernelBrowser
    {
        $this->client->request(
            $method,
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'ACCEPT' => 'application/json',
            ],
            json_encode($data)
        );

        return $this->client;
    }

    protected function assertJsonResponse(Response $response, int $expectedStatus): void
    {
        $this->assertSame($expectedStatus, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    protected function createUser(): User
    {
        $userRepo = static::getContainer()->get(UserRepository::class);
        $persister = static::getContainer()->get(UserRegisterCreatePersister::class);

        $dto = new StoreRegisterUserRequestDTO(
            email: 'user@example.com',
            password: 'Password123$',
            passwordConfirmation: 'Password123$',
            firstname: 'Test',
            surname: 'User',
        );

        $object = $persister->persist($dto);
        $user = $userRepo->findOneBy(['email' => $dto->email]);

        $this->assertNotNull($user);
        $this->assertSame($user->getEmail(), $object->getEmail());

        return $user;
    }

    protected function assertIsApiResponse(array $responseContent): void
    {
        $this->assertArrayHasKey('data', $responseContent);
        $this->assertArrayHasKey('meta', $responseContent);
        $this->assertArrayHasKey('errors', $responseContent);
    }

    protected function login(string $email, string $password): void
    {
        $this->sendJsonRequest('POST', '/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);
        $this->assertIsApiResponse($this->getJsonResponseData());
        $this->assertResponseHasCookie('BEARER');
    }

}
