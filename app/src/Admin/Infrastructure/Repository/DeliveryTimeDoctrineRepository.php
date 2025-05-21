<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Entity\DeliveryTime;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class DeliveryTimeDoctrineRepository extends AbstractCriteriaRepository implements DeliveryTimeRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return DeliveryTime::class;
    }

    protected function getAlias(): string
    {
        return 'delivery_time';
    }

    public function getMaxOrder(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
