<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

interface UpdateOrderControllerInterface
{
    public function getOrderSortableRepository(): OrderSortableRepositoryInterface|AbstractRepository;

    public function getEntityManager(): EntityManagerInterface;
}
