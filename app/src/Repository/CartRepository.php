<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use App\Repository\Base\DoctrineRepository;

class CartRepository extends DoctrineRepository
{
    public function findByToken(?string $token): ?Cart
    {
        return $this->findOneBy(['token' => $token]);
    }

    protected function getEntityClass(): string
    {
        return Cart::class;
    }
}
