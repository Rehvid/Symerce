<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Carrier;

use App\Shared\Domain\ValueObject\Money;

final readonly class CarrierListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public Money $fee,
        public ?string $imagePath,
    ) {
    }
}
