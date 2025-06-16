<?php

declare(strict_types=1);

namespace App\Order\Domain\Repository;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Order>
 */
interface OrderRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    public function findByToken(?string $token): ?Order;

    public function findLatestOrders(int $limit): array;

}
