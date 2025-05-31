<?php

declare (strict_types = 1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailShippingResponse
{
    public function __construct(
        public string $name,
        public string $fee,
    ) {}
}
