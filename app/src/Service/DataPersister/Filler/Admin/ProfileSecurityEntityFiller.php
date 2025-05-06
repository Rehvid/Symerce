<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\PersistableInterface;
use App\DTO\Admin\Request\Profile\UpdateSecurityRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends BaseEntityFiller<UpdateSecurityRequestDTO>
 */
final class ProfileSecurityEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function toNewEntity(PersistableInterface|UpdateSecurityRequestDTO $persistable): UpdateSecurityRequestDTO
    {
        return $persistable;
    }

    /**
     * @param User $entity
     */
    public function toExistingEntity(PersistableInterface|UpdateSecurityRequestDTO $persistable, object $entity): User
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return UpdateSecurityRequestDTO::class;
    }

    /**
     * @param User $entity
     */
    protected function fillEntity(PersistableInterface|UpdateSecurityRequestDTO $persistable, object $entity): User
    {
        $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));

        return $entity;
    }
}
