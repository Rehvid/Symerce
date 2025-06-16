<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailItemResponse
{
    public function __construct(
        public ?string $name,
        public ?string $imageUrl,
        public string $unitPrice,
        public int $quantity,
        public string $totalPrice,
        public ?string $editUrl
    ) {
    }
}
