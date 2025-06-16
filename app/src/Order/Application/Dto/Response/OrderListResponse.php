<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response;

use App\Common\Domain\ValueObject\MoneyVO;

final readonly class OrderListResponse
{
    public function __construct(
        public ?int $id,
        public string $checkoutStep,
        public string $status,
        public ?MoneyVO $totalPrice,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }
}
