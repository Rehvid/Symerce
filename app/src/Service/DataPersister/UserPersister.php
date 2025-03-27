<?php

declare(strict_types=1);

namespace App\Service\DataPersister;

use App\Dto\Request\User\SaveUserDTO;
use App\Entity\User;
use App\Enums\Roles;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\AbstractDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserPersister extends AbstractDataPersister
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    protected function createEntityFromDto(PersistableInterface $persistable): object
    {
        /** @var SaveUserDTO $persistable */
        $user = new User();
        $user->setEmail($persistable->email);
        $user->setRoles([Roles::ROLE_USER->value]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $persistable->password));
        $user->setIsActive(true);

        return $user;
    }

    protected function updateEntityFromDto(object $entity, PersistableInterface $persistable): object
    {
        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveUserDTO::class, User::class];
    }
}
