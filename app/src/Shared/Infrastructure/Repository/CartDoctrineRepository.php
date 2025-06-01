<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Common\Domain\Entity\Cart;
use App\Shared\Domain\Repository\CartRepositoryInterface;

class CartDoctrineRepository extends DoctrineRepository implements CartRepositoryInterface
{
    public function findByToken(?string $token): ?Cart
    {
        return $this->findOneBy(['token' => $token]);
    }

    protected function getEntityClass(): string
    {
        return Cart::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }
}
