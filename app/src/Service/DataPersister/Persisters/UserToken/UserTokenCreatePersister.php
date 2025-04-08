<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\UserToken;

use App\DTO\Request\UserToken\StoreUserTokenRequestDTO;
use App\Entity\UserToken;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;

class UserTokenCreatePersister extends CreatePersister
{
    protected function createEntity(PersistableInterface $persistable): object
    {
        /** @var StoreUserTokenRequestDTO $persistable */
        $userToken = new UserToken();
        $userToken->setToken($persistable->token);
        $userToken->setTokenType($persistable->tokenType);
        $userToken->setExpiresAt($persistable->expiresAt);
        $userToken->setUser($persistable->user);

        return $userToken;
    }

    public function getSupportedClasses(): array
    {
        return [StoreUserTokenRequestDTO::class];
    }
}
