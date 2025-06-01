<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Common\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;


final class OrderDoctrineRepository extends AbstractCriteriaRepository implements OrderRepositoryInterface
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
