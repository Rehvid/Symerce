<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CarrierRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{

}
