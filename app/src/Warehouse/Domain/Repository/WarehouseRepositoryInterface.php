<?php

declare(strict_types=1);

namespace App\Warehouse\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface WarehouseRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{

}
