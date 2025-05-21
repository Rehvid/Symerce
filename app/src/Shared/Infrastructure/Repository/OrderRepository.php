<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Repository\OrderRepositoryInterface;


class OrderRepository extends DoctrineRepository implements OrderRepositoryInterface
{

    public function findByToken(?string $token): ?Order
    {
        return $this->findOneBy(['cartToken' => $token]);
    }

    protected function getEntityClass(): string
    {
        return Order::class;
    }

    protected function getAlias(): string
    {
        return 'o';
    }
}
