<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Common\Domain\Entity\Product;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Product>
 */
interface ProductRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
    public function countProductsByBrand(int $brandId): int;

    public function findBestSellingProducts(int $limit): array;
}
