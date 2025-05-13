<?php

declare(strict_types=1);

namespace App\DTO\Shop\Request\Cart;

use App\DTO\Admin\Request\PersistableInterface;

final readonly class SaveCartDTO implements PersistableInterface
{
    public function __construct(
        public int $productId,
        public int $quantity,
        public string $method,
        public ?string $cartToken = null
    ){

    }
}
