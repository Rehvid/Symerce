<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\Common\Domain\Entity\UserToken;
use App\Common\Infrastructure\Repository\Abstract\DoctrineRepository;
use App\User\Domain\Repository\UserTokenRepositoryInterface;

final class UserTokenRepository extends DoctrineRepository implements UserTokenRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return UserToken::class;
    }

    protected function getAlias(): string
    {
        return 'user_token';
    }

    public function findByToken(string $token): ?UserToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}
