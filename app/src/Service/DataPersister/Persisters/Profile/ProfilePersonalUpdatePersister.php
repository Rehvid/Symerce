<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Profile;

use App\DTO\Request\Profile\ProfileInformationRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

final class ProfilePersonalUpdatePersister extends UpdatePersister
{
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        /** @var User $entity */
        /** @var ProfileInformationRequestDTO $persistable */

        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);
        $entity->setEmail($persistable->email);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [ProfileInformationRequestDTO::class, User::class];
    }
}
