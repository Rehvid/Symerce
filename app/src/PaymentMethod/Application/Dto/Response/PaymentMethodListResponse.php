<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Response;

use App\Shared\Domain\ValueObject\Money;

final readonly class PaymentMethodListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public bool $isActive,
        public Money $fee,
        public ?string $imagePath
    ) {
    }
}
