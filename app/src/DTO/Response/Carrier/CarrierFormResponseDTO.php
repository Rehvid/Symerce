<?php

declare(strict_types=1);

namespace App\DTO\Response\Carrier;

use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\ResponseInterfaceData;

final class CarrierFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public readonly string $name,
        public readonly string $fee,
        public readonly bool $isActive,
        public ?FileResponseDTO $image,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
            fee: $data['fee'],
            isActive: $data['isActive'],
            image: $data['image'],
        );
    }
}
