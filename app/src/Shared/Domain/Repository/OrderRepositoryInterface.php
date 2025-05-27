<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Shared\Domain\Entity\Order;

interface OrderRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    public function findByToken(?string $token): ?Order;
}
