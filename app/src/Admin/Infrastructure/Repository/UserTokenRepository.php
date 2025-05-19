<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\UserTokenRepositoryInterface;
use App\Entity\UserToken;
use App\Repository\Base\AbstractRepository;
use App\Shared\Infrastructure\Repository\DoctrineRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserToken>
 */
class UserTokenRepository extends DoctrineRepository implements UserTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    protected function getEntityClass(): string
    {
        return UserToken::class;
    }

    protected function getAlias(): string
    {
        return 'ut';
    }
}
