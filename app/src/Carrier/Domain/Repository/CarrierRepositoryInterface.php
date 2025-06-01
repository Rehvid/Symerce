<?php

declare(strict_types=1);

namespace App\Carrier\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CarrierRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{

}
