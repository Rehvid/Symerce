<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Traits;

trait PositionRepositoryTrait
{
    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array
    {
        $alias = $this->getAlias();
        $queryBuilder = $this->createQueryBuilder($alias);

        if ($oldOrder < $newOrder) {
            return $queryBuilder->where("$alias.order > :oldOrder")
                ->andWhere("$alias.order <= :newOrder")
                ->setParameter('oldOrder', $oldOrder)
                ->setParameter('newOrder', $newOrder)
                ->orderBy("$alias.order", 'ASC')
                ->getQuery()
                ->getResult()
                ;
        }

        return $queryBuilder->where("$alias.order >= :newOrder")
            ->andWhere("$alias.order < :oldOrder")
            ->setParameter('newOrder', $newOrder)
            ->setParameter('oldOrder', $oldOrder)
            ->orderBy("$alias.order", 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getMaxPosition(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
