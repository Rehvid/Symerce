<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\Enums\SettingType;

class ProviderResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public SettingType $type,
        public array|string $value
    )
    {

    }


    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            type: $data['type'],
            value: $data['value']
        );
    }
}
