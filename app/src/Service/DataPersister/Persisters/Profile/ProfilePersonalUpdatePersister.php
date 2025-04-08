<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Profile;

use App\DTO\Request\Profile\UpdatePersonalRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

final class ProfilePersonalUpdatePersister extends UpdatePersister
{
    /**
     * @param UpdatePersonalRequestDTO $persistable
     * @param User                     $entity
     *
     * @return User
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);
        $entity->setEmail($persistable->email);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [UpdatePersonalRequestDTO::class, User::class];
    }
}
