<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Dto\Request\RegistrationDto;
use App\Entity\User;
use App\Enums\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class RegisterUserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function register(RegistrationDto $dto): void
    {
        $this->entityManager->persist($this->createUser($dto));
        $this->entityManager->flush();
    }

    private function createUser(RegistrationDto $dto): User
    {
        $user = new User();
        $user->setEmail($dto->email);
        $user->setRoles([Roles::ROLE_USER->value]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));
        $user->setIsActive(true);

        return $user;
    }
}
