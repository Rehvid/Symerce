<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\User\StoreRegisterUserRequestDTO;
use App\Entity\User;
use App\Enums\Roles;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends BaseEntityFiller<StoreRegisterUserRequestDTO>
 */
final class UserRegisterEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function toNewEntity(PersistableInterface $persistable): User
    {
        return $this->fillEntity($persistable, new User());
    }

    /**
     * @param User $entity
     */
    public function toExistingEntity(PersistableInterface $persistable, object $entity): User
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return StoreRegisterUserRequestDTO::class;
    }

    /**
     * @param User $entity
     */
    protected function fillEntity(StoreRegisterUserRequestDTO|PersistableInterface $persistable, object $entity): User
    {
        $entity->setEmail($persistable->email);
        $entity->setRoles([Roles::ROLE_USER->value]);
        $entity->setPassword($this->passwordHasher->hashPassword($entity, $persistable->password));
        $entity->setIsActive(true);
        $entity->setFirstname($persistable->firstname);
        $entity->setSurname($persistable->surname);

        return $entity;
    }
}
