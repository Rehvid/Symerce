<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\User;

use App\Dto\Request\User\SaveUserDTO;
use App\Entity\User;
use App\Enums\Roles;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserCreatePersister extends CreatePersister
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    protected function createEntity(PersistableInterface $persistable): object
    {
        /** @var SaveUserDTO $persistable */
        $user = new User();
        $user->setEmail($persistable->email);
        $user->setRoles([Roles::ROLE_USER->value]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $persistable->password));
        $user->setIsActive(true);
        $user->setFirstname($persistable->firstname);
        $user->setSurname($persistable->surname);

        return $user;
    }

    public function getSupportedClasses(): array
    {
        return [SaveUserDTO::class];
    }
}
