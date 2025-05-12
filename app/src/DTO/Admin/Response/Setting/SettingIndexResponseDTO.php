<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class SettingIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public string $type,
        public bool $isActive,
        public bool $isProtected,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            type: $data['type'],
            isActive: $data['isActive'],
            isProtected: $data['isProtected'],
        );
    }
}
