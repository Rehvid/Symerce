<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Profile;

use App\DTO\Request\Profile\UpdatePersonalRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;

final class ProfilePersonalUpdatePersister extends UpdatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly FileService $fileService,
    ){
        parent::__construct($entityManager);
    }


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

        if (!empty($persistable->avatar)) {
            foreach ($persistable->avatar as $image) {
                $entity->setAvatar($this->fileService->processFileRequestDTO($image, $entity->getAvatar()));
            }
        }

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [UpdatePersonalRequestDTO::class, User::class];
    }
}
