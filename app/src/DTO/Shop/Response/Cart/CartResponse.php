<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Cart;

final readonly class CartResponse
{
    public function __construct(
        public int $id,
        public array $cartItems,
    )
    {

    }
}
