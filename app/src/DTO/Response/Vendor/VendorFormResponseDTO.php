<?php

declare(strict_types=1);

namespace App\DTO\Response\Vendor;

use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\ResponseInterfaceData;

final class VendorFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $name,
        public bool $isActive,
        public ?FileResponseDTO $image,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
            isActive: $data['isActive'],
            image: $data['image'],
        );
    }
}
