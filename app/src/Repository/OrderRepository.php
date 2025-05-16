<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Repository\Base\DoctrineRepository;

class OrderRepository extends DoctrineRepository
{

    protected function getEntityClass(): string
    {
        return Order::class;
    }

    public function findByToken(string $token): ?Order
    {
        return $this->findOneBy(['cartToken' => $token]);
    }
}
