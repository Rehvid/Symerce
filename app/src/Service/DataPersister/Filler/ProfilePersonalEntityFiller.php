<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\Profile\UpdatePersonalRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;

/**
 * @extends BaseEntityFiller<UpdatePersonalRequestDTO>
 */
final class ProfilePersonalEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly FileService $fileService)
    {
    }

    public function toNewEntity(PersistableInterface|UpdatePersonalRequestDTO $persistable): UpdatePersonalRequestDTO
    {
        return $persistable;
    }

    /**
     * @param User $entity
     */
    public function toExistingEntity(PersistableInterface|UpdatePersonalRequestDTO $persistable, object $entity): User
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return UpdatePersonalRequestDTO::class;
    }

    /**
     * @param User $entity
     */
    protected function fillEntity(PersistableInterface|UpdatePersonalRequestDTO $persistable, object $entity): User
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
}
