<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Response\Cart;

final readonly class CartSaveResponse
{
    public function __construct(
        public int $totalQuantity,
    ) {
    }
}
