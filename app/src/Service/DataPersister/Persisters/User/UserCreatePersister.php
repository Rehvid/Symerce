<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\User;

use App\DTO\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreatePersister extends CreatePersister
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly FileService $fileService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }


    /** @param SaveUserRequestDTO $persistable */
    protected function createEntity(PersistableInterface $persistable): object
    {
        $user = new User();
        $user->setEmail($persistable->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $persistable->password));
        $user->setFirstname($persistable->firstname);
        $user->setSurname($persistable->surname);
        $user->setRoles($persistable->roles);
        $user->setIsActive($persistable->isActive);
        if (!empty($persistable->avatar)) {
            foreach ($persistable->avatar as $image) {
                $user->setAvatar($this->fileService->processFileRequestDTO($image, $user->getAvatar()));
            }
        }

        return $user;
    }

    public function getSupportedClasses(): array
    {
        return [SaveUserRequestDTO::class];
    }
}
