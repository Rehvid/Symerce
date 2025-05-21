<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Request\Cart;


final class SaveCartRequest
{
    public function __construct(
        public string|int $productId,
        public int $quantity,
        public ?string $cartToken = null
    ){

    }

    public function getCartToken(): ?string
    {
        return $this->cartToken;
    }

    public function setCartToken(?string $cartToken): void
    {
        $this->cartToken = $cartToken;
    }
}
