<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Common\Domain\Entity\Product;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;
use App\Product\Domain\Repository\ProductRepositoryInterface;

/**
 * @extends AbstractCriteriaRepository<Product>
 */
final class ProductDoctrineRepository extends AbstractCriteriaRepository implements ProductRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'product';
    }

   public function countProductsByBrand(int $brandId): int
   {
       return (int) $this->createQueryBuilder('p')
           ->select('COUNT(p.id)')
           ->where('p.brand = :brandId')
           ->setParameter('brandId', $brandId)
           ->getQuery()
           ->getSingleScalarResult();
   }

    public function findBestSellingProducts(int $limit): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->select("$alias, SUM(orderItem.quantity) AS quantity")
            ->leftJoin("$alias.orderItems", 'orderItem')
            ->groupBy("$alias.id")
            ->orderBy('quantity', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
