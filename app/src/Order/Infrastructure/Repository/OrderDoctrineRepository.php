<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Common\Domain\Entity\Order;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Order\Domain\Repository\OrderRepositoryInterface;


final class OrderDoctrineRepository extends AbstractCriteriaRepository implements OrderRepositoryInterface
{

    public function findByToken(?string $token): ?Order
    {
        return $this->findOneBy(['cartToken' => $token]);
    }

    public function findLatestOrders(int $limit): array
    {
        return $this->findBy([], ['createdAt' => 'DESC'], $limit);
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
