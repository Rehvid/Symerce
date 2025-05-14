<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Cart;

final readonly class CartItemResponse
{
    public function __construct(
        public int $id,
        public int $quantity,
        public string $price,
        public int $productId,
        public string $productName,
        public string $productUrl,
        public ?string $productImage,
    ) {

    }
}
