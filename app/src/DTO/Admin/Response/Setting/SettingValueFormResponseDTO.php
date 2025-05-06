<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Enums\SettingValueType;

class SettingValueFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public SettingValueType $type,
        public mixed $value,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            type: $data['type'],
            value: $data['value'] ?? null,
        );
    }
}
