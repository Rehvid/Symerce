<?php

namespace App\DTO\Response\Setting;

use App\DTO\Response\ResponseInterfaceData;

class SettingUpdateFormResponseDTO extends SettingFormResponseDTO
{
    private function __construct(
        array $types,
        public string $name,
        public string $type,
        public string $value,
        public bool $isProtected,

    ){
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
        );
    }
}
