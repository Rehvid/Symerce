<?php

declare(strict_types=1);

namespace App\Cart\Application\Dto\Response;

final readonly class CartListResponse
{
    public function __construct(
        public int $id,
        public ?int $orderId,
        public ?string $customer,
        public ?string $total,
        public string $expiresAt,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }
}
