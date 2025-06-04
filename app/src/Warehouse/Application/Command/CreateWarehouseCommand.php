<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class CreateWarehouseCommand implements CommandInterface
{
    public function __construct(public WarehouseData $data) {}
}
