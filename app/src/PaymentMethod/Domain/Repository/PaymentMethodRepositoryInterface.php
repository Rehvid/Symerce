<?php

declare(strict_types=1);

namespace App\PaymentMethod\Domain\Repository;

use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<PaymentMethod>
 */
interface PaymentMethodRepositoryInterface extends
    QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
}
