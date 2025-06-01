<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class DeliveryTimeDoctrineRepository extends AbstractCriteriaRepository implements DeliveryTimeRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return DeliveryTime::class;
    }

    protected function getAlias(): string
    {
        return 'delivery_time';
    }
}
