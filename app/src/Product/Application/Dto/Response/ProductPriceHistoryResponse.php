<?php

namespace App\Product\Application\Dto\Response;

final readonly class ProductPriceHistoryResponse
{
    public function __construct(
        public int $id,
        public string $basePrice,
        public ?string $discountPrice,
        public ?int $productId,
        public string $createdAt
    ) {
    }
}
