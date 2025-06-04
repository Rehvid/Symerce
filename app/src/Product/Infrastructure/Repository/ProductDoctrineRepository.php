<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Common\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

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
}
