<?php

namespace App\Warehouse\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class UpdateWarehouseCommand implements CommandInterface
{
    public function __construct(
        public WarehouseData $data,
        public int $warehouseId
    ) {}
}
