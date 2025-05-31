<?php

declare(strict_types=1);

namespace App\Order\Application\Dto;

use App\Admin\Domain\Entity\Product;

final readonly class OrderItemData
{
    public function __construct(
        public Product $product,
        public int $quantity,
    ) {
    }
}
