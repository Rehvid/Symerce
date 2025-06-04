<?php

declare(strict_types=1);

namespace App\Cart\Application\Dto\Response;

final readonly class CartDetailItemResponse
{
    public function __construct(
        public ?string $name,
        public ?string $imageUrl,
        public string $unitPrice,
        public int $quantity,
        public string $totalPrice,
        public ?string $editUrl
    ) {}
}
