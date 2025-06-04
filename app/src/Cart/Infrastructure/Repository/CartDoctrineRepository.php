<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Repository;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Domain\Entity\Cart;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;


final class CartDoctrineRepository extends AbstractCriteriaRepository implements CartRepositoryInterface
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
        return 'cart';
    }
}
