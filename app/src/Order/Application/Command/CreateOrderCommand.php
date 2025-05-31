<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Application\Dto\OrderData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        public OrderData $data
    ) {}
}
