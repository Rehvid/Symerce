<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\UserTokenRepositoryInterface;
use App\Entity\UserToken;
use App\Shared\Infrastructure\Repository\DoctrineRepository;

class UserTokenRepository extends DoctrineRepository implements UserTokenRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return UserToken::class;
    }

    protected function getAlias(): string
    {
        return 'ut';
    }

    public function findByToken(string $token): ?UserToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}
