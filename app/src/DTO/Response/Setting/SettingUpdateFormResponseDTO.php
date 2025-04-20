<?php

namespace App\DTO\Response\Setting;

use App\DTO\Response\ResponseInterfaceData;

final class SettingUpdateFormResponseDTO extends SettingFormResponseDTO
{
    /** @param array<int, mixed>  $types */
    private function __construct(
        array $types,
        public string $name,
        public string $type,
        public string $value,
        public bool $isProtected,
        public ?SettingValueFormResponseDTO $settingValue,
    ) {
        parent::__construct($types);
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            types: $data['types'],
            name: $data['name'],
            type: $data['type'],
            value: $data['value'],
            isProtected: $data['isProtected'],
            settingValue: $data['settingValue'],
        );
    }
}
