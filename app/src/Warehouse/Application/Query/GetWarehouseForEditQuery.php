<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetWarehouseForEditQuery implements QueryInterface
{
    public function __construct(
        public int $warehouseId,
    ) {}
}
