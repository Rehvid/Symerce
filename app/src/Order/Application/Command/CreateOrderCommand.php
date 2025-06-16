<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Order\Application\Dto\OrderData;

final readonly class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        public OrderData $data
    ) {
    }
}
