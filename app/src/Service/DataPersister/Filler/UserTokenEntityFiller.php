<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\UserToken\StoreUserTokenRequestDTO;
use App\Entity\UserToken;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<StoreUserTokenRequestDTO>
 */
final class UserTokenEntityFiller extends BaseEntityFiller
{
    public function toNewEntity(PersistableInterface|StoreUserTokenRequestDTO $persistable): UserToken
    {
        return $this->fillEntity($persistable, new UserToken());
    }

    /**
     * @param UserToken $entity
     */
    public function toExistingEntity(
        PersistableInterface|StoreUserTokenRequestDTO $persistable,
        object $entity
    ): UserToken {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return StoreUserTokenRequestDTO::class;
    }

    /**
     * @param UserToken $entity
     */
    protected function fillEntity(
        PersistableInterface|StoreUserTokenRequestDTO $persistable,
        object $entity
    ): UserToken {
        $entity->setToken($persistable->token);
        $entity->setTokenType($persistable->tokenType);
        $entity->setExpiresAt($persistable->expiresAt);
        $entity->setUser($persistable->user);

        return $entity;
    }
}
