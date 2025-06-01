<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class GetWarehouseForEditQuery implements QueryInterface
{
    public function __construct(
        public int $warehouseId,
    ) {}
}
