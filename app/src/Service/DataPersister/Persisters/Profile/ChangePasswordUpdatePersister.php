<?php

declare (strict_types = 1);

namespace App\Service\DataPersister\Persisters\Profile;

use App\DTO\Request\Profile\ChangePasswordRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class ChangePasswordUpdatePersister extends UpdatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
        parent::__construct($entityManager);
    }

    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        /** @var User $entity */
        /** @var ChangePasswordRequestDTO $persistable */
        $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [ChangePasswordRequestDTO::class, User::class];
    }
}
