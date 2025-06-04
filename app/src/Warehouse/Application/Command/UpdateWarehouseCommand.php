<?php

namespace App\Warehouse\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class UpdateWarehouseCommand implements CommandInterface
{
    public function __construct(
        public WarehouseData $data,
        public int $warehouseId
    ) {}
}
