<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Profile;

use App\DTO\Request\Profile\UpdateSecurityRequestDTO;
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
    ) {
        parent::__construct($entityManager);
    }

    /**
     * @param UpdateSecurityRequestDTO $persistable
     * @param User                     $entity
     *
     * @return User
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {

        $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [UpdateSecurityRequestDTO::class, User::class];
    }
}
