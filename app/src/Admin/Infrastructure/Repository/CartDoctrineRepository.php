<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CartRepositoryInterface;
use App\Entity\Cart;
use App\Shared\Infrastructure\Repository\DoctrineRepository;

class CartDoctrineRepository extends DoctrineRepository implements CartRepositoryInterface
{
    public function findByToken(?string $token): ?Cart
    {
        return $this->findOneBy(['token' => $token]);
    }

    public function findByCartToken(?string $token): ?Cart
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
