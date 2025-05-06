<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response;

use App\Enums\SettingType;

class ProviderResponseDTO implements ResponseInterfaceData
{
    /** @param array<int,mixed>|string $value  */
    private function __construct(
        public SettingType $type,
        public array|string $value
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            type: $data['type'],
            value: $data['value']
        );
    }
}
