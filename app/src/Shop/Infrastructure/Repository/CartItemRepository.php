<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Repository;

use App\Common\Domain\Entity\CartItem;
use App\Common\Infrastructure\Repository\Abstract\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

class CartItemRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    protected function getEntityClass(): string
    {
        return CartItem::class;
    }

    protected function getAlias(): string
    {
        return 'ct';
    }
}
