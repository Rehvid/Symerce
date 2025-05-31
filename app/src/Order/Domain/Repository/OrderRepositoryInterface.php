<?php

declare(strict_types=1);

namespace App\Order\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface OrderRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    public function findByToken(?string $token): ?Order;
}
