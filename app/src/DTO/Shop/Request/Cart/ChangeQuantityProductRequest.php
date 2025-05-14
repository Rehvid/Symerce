<?php

declare(strict_types=1);

namespace App\DTO\Shop\Request\Cart;

final readonly class ChangeQuantityProductRequest
{
    public function __construct(
        public int $productId,
        public int $newQuantity,
    ) {

    }
}
