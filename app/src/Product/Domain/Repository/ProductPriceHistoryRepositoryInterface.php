<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;


use App\Common\Domain\Entity\ProductPriceHistory;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<ProductPriceHistory>
 */
interface ProductPriceHistoryRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    public function findLowestInLast30Days(int $productId): string;
}
