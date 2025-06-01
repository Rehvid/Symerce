<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class ProductDoctrineRepository extends AbstractCriteriaRepository implements ProductRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'p';
    }
}
