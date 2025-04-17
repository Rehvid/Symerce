<?php

declare(strict_types=1);

namespace App\DTO\Response\Carrier;

use App\DTO\Response\ResponseInterfaceData;
use App\ValueObject\Money;

final class CarrierIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public Money $fee,
        public ?string $imagePath,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            isActive: $data['isActive'],
            fee: $data['fee'],
            imagePath: $data['imagePath'],
        );
    }
}
