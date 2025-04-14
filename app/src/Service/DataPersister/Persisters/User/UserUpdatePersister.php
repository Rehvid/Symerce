<?php

namespace App\Service\DataPersister\Persisters\User;

use App\DTO\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserUpdatePersister extends UpdatePersister
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly FileService $fileService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    /**
     * @param SaveUserRequestDTO $persistable
     * @param User $entity
     * @return User
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setEmail($persistable->email);
        $entity->setRoles($persistable->roles);
        $entity->setIsActive(true);
        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);

        if ($persistable->password) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));
        }

        if (!empty($persistable->avatar)) {
            foreach ($persistable->avatar as $image) {
                $entity->setAvatar($this->fileService->processFileRequestDTO($image, $entity->getAvatar()));
            }
        }

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveUserRequestDTO::class, User::class];
    }
}
