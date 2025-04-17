<?php

declare(strict_types=1);

namespace App\DTO\Response\Setting;

use App\DTO\Response\ResponseInterfaceData;

final readonly class SettingIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public string $value,
        public string $type,
        public bool $isProtected,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            value: $data['value'],
            type: $data['type'],
            isProtected: $data['isProtected'],
        );
    }
}
