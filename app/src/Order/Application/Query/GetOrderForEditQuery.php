<?php

declare(strict_types=1);

namespace App\Order\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Domain\Entity\Order;

final readonly class GetOrderForEditQuery implements QueryInterface
{
    public function __construct(
        public int $orderId,
    ) {}
}
