<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Common\Domain\Entity\Product;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;
use App\Product\Domain\Repository\ProductRepositoryInterface;

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
}
