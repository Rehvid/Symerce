<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Common\Domain\Entity\ProductPriceHistory;
use App\Common\Infrastructure\Repository\Abstract\DoctrineRepository;
use App\Product\Domain\Repository\ProductPriceHistoryRepositoryInterface;

/**
 * @extends DoctrineRepository<ProductPriceHistory>
 */
class ProductPriceHistoryRepositoryDoctrineRepository extends DoctrineRepository implements ProductPriceHistoryRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return ProductPriceHistory::class;
    }

    protected function getAlias(): string
    {
        return 'pph';
    }

    public function findLowestInLast30Days(int $productId): string
    {
        $alias = $this->getAlias();
        $since = new \DateTimeImmutable('-30 days');

        $result = $this->createQueryBuilder($this->getAlias())
            ->select("MIN($alias.price) as min_price")
            ->andWhere("$alias.productId = :id")
            ->andWhere("$alias.createdAt >= :since")
            ->setParameter('id', $productId)
            ->setParameter('since', $since)
            ->getQuery()
            ->getSingleScalarResult();

        return (string) ($result ?? '0');
    }
}
