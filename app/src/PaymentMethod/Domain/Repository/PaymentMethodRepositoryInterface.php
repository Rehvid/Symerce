<?php

declare(strict_types=1);

namespace App\PaymentMethod\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Admin\Domain\Repository\PositionRepositoryInterface;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface PaymentMethodRepositoryInterface extends
    QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
}
