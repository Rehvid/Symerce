<?php

declare(strict_types=1);

namespace App\Cart\Application\Dto\Response;

final readonly class CartDetailResponse
{
    /** @param CartDetailItemResponse[] $items */
    public function __construct(
        public int $id,
        public string $createdAt,
        public string $updatedAt,
        public string $expiresAt,
        public ?string $customer,
          public array $items
    ) {}
}
