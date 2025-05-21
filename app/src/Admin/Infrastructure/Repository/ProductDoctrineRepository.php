<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Entity\Product;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class ProductDoctrineRepository extends AbstractCriteriaRepository implements ProductRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'p';
    }

    public function getMaxOrder(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
