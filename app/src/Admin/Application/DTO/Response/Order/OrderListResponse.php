<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order;

use App\Shared\Domain\ValueObject\Money;

final readonly class OrderListResponse
{

    public function __construct(
        public int $id,
        public string $checkoutStep,
        public string $status,
        public ?Money $totalPrice,
        public ?string $createdAt,
        public ?string $updatedAt,
    ){}
}
