<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;


interface ProductPriceHistoryRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    public function findLowestInLast30Days(int $productId): string;
}
