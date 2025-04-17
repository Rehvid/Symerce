<?php

declare(strict_types=1);

namespace App\DTO\Response\Vendor;

use App\DTO\Response\ResponseInterfaceData;

final readonly class VendorIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public ?string $imagePath = null,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            imagePath: $data['imagePath'],
        );
    }
}
