<?php

namespace App\DTO\Response\Carrier;

use App\DTO\Response\ResponseInterfaceData;

class CarrierIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public string $fee,
        public ?string $imagePath,
    ){
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
