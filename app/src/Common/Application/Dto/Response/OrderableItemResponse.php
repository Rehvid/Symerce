<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Response;

final readonly class OrderableItemResponse
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
