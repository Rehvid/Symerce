<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailInformationResponse
{
    public function __construct(
        public ?int $id,
        public string $uuid,
        public string $orderStatus,
        public string $checkoutStatus,
        public string $createdAt,
        public string $updatedAt
    ) {
    }
}
