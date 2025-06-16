<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Traits;

use App\Common\Domain\Contracts\PositionEntityInterface;

trait PositionRepositoryTrait
{
    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array
    {
        $alias = $this->getAlias();
        $queryBuilder = $this->createQueryBuilder($alias);

        if ($oldOrder < $newOrder) {
            return $queryBuilder->where("$alias.position > :oldOrder")
                ->andWhere("$alias.position <= :newOrder")
                ->setParameter('oldOrder', $oldOrder)
                ->setParameter('newOrder', $newOrder)
                ->orderBy("$alias.position", 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        return $queryBuilder->where("$alias.position >= :newOrder")
            ->andWhere("$alias.position < :oldOrder")
            ->setParameter('newOrder', $newOrder)
            ->setParameter('oldOrder', $oldOrder)
            ->orderBy("$alias.position", 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMaxPosition(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.position)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByMovedId(int $movedId): ?PositionEntityInterface
    {
        return $this->find($movedId);
    }
}
