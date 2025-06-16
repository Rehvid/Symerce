<?php

declare(strict_types=1);

namespace App\Warehouse\Domain\Repository;

use App\Common\Domain\Entity\Warehouse;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Warehouse>
 */
interface WarehouseRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
}
