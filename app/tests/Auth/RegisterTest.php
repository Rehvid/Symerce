<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Admin\Infrastructure\Repository\UserDoctrineRepository;
use App\Entity\User;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends ApiTestCase
{
    private function getUserByEmail(string $email): ?User
    {
        return static::getContainer()->get(UserDoctrineRepository::class)->findOneBy(['email' => $email]);
    }

    public function testSuccessfulRegister(): void
    {
        $data = [
            'email' => 'test@localhost.com',
            'password' => 'Password123$',
            'passwordConfirmation' => 'Password123$',
            'firstname' => 'Test',
            'surname' => 'User',
        ];

        $client = $this->sendJsonRequest(Request::METHOD_POST, 'api/auth/register', $data);

        $this->assertJsonResponse($client->getResponse(), Response::HTTP_CREATED);

        $user = $this->getUserByEmail($data['email']);

        $this->assertNotNull($user);
        $this->assertSame($data['email'], $user->getEmail());
        $this->assertEquals($data['email'], $user->getEmail());
    }

    public function testRegisterWithInvalidEmail(): void
    {
        $data = [
            'email' => 'invalid-email',
            'password' => 'Password123$',
            'passwordConfirmation' => 'Password123$',
            'firstname' => 'Test',
            'surname' => 'User',
        ];

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/register', $data);
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_BAD_REQUEST);
    }

    public function testRegisterWithMismatchedPasswords(): void
    {
        $data = [
            'email' => 'test2@test.com',
            'password' => 'Password123$',
            'passwordConfirmation' => 'Different123$',
            'firstname' => 'Test',
            'surname' => 'User',
        ];

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/register', $data);
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_BAD_REQUEST);
    }

    public function testRegisterWithMissingFields(): void
    {
        $data = [
            'email' => '',
            'password' => '',
            'passwordConfirmation' => '',
            'firstname' => '',
            'surname' => '',
        ];

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/register', $data);
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_BAD_REQUEST);
    }

    public function testRegisterWithExistingEmail(): void
    {
        $user = $this->createUser();

        $data = [
            'email' => $user->getEmail(),
            'password' => 'Password123$',
            'passwordConfirmation' => 'Password123$',
            'firstname' => 'John',
            'surname' => 'Doe',
        ];

        $client = $this->sendJsonRequest(Request::METHOD_POST, '/api/auth/register', $data);
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
