<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

final readonly class SaveOrderProductRequest
{
    public function __construct(
        public int $productId,
        public int|string $quantity
    ) {
    }
}
