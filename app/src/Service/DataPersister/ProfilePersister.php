<?php

namespace App\Service\DataPersister;

use App\Dto\Request\User\Profile\ProfileInformationDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\AbstractDataPersister;

final class ProfilePersister extends AbstractDataPersister
{

    protected function createEntityFromDto(PersistableInterface $persistable): object
    {
        return $persistable;
    }


    protected function updateEntityFromDto(object $entity, PersistableInterface $persistable): object
    {
        /** @var User $entity */
        /** @var ProfileInformationDTO $persistable */

        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);
        $entity->setEmail($persistable->email);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [ProfileInformationDTO::class, User::class];
    }
}
