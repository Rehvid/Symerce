<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Entity\Order;


class OrderRepository extends DoctrineRepository
{

    public function findByToken(string $token): ?Order
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
