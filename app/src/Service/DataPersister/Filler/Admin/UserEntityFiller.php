<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\PersistableInterface;
use App\DTO\Admin\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends BaseEntityFiller<SaveUserRequestDTO>
 */
final class UserEntityFiller extends BaseEntityFiller
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly FileService $fileService
    ) {
    }

    public function toNewEntity(PersistableInterface|SaveUserRequestDTO $persistable): User
    {
        return $this->fillEntity($persistable, new User());
    }

    /**
     * @param User $entity
     */
    public function toExistingEntity(PersistableInterface|SaveUserRequestDTO $persistable, object $entity): User
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveUserRequestDTO::class;
    }

    /**
     * @param User $entity
     */
    protected function fillEntity(PersistableInterface|SaveUserRequestDTO $persistable, object $entity): User
    {
        $entity->setEmail($persistable->email);
        if (null !== $persistable->password) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));
        }
        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);
        $entity->setRoles($persistable->roles);
        $entity->setIsActive($persistable->isActive);
        if (!empty($persistable->avatar)) {
            foreach ($persistable->avatar as $image) {
                $entity->setAvatar($this->fileService->processFileRequestDTO($image, $entity->getAvatar()));
            }
        }

        return $entity;
    }
}
