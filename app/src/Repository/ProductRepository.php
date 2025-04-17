<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Repository\Base\PaginationRepository;

class ProductRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'p';
    }
}
