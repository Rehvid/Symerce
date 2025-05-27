<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Order;

final readonly class SaveOrderProductRequest
{
    public function __construct(
        public int $productId,
        public int|string $quantity
    ) {
    }
}
