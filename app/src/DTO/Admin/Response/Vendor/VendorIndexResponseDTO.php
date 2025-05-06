<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Vendor;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class VendorIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public ?string $imagePath = null,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            isActive: $data['isActive'],
            imagePath: $data['imagePath'],
        );
    }
}
