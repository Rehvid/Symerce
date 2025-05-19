<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Carrier;

use App\DTO\Admin\Response\FileResponseDTO;
use App\Shared\Domain\ValueObject\Money;

final readonly class CarrierFormResponse
{
    public function __construct(
        public string $name,
        public Money $fee,
        public bool $isActive,
        public ?FileResponseDTO $image,
    ) {
    }
}
