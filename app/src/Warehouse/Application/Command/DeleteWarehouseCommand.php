<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteWarehouseCommand implements CommandInterface
{
    public function __construct(public int $warehouseId) {}
}
