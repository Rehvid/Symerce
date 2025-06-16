<?php

declare(strict_types=1);

namespace App\Warehouse\Infrastructure\Repository;

use App\Common\Domain\Entity\Warehouse;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;

/**
 * @extends AbstractCriteriaRepository<Warehouse>
 */
final class WarehouseDoctrineRepository extends AbstractCriteriaRepository implements WarehouseRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'warehouse';
    }

    protected function getEntityClass(): string
    {
        return Warehouse::class;
    }
}
