<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Request\Cart;

final readonly class ChangeQuantityProductRequest
{
    public function __construct(
        public int $productId,
        public int $newQuantity,
    ) {

    }
}
