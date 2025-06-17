<?php

declare(strict_types=1);

namespace App\Cart\Application\Dto\Response;

use App\Common\Application\Dto\Response\OrderableItemResponse;

final readonly class CartDetailResponse
{
    /** @param OrderableItemResponse[] $items */
    public function __construct(
        public int $id,
        public string $createdAt,
        public string $updatedAt,
        public string $expiresAt,
        public ?string $customer,
        public array $items
    ) {
    }
}
