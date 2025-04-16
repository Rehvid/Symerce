<?php

namespace App\DTO\Response\Setting;

use App\DTO\Response\ResponseInterfaceData;

class SettingFormResponseDTO implements ResponseInterfaceData
{

    protected function __construct(
        public array $types,
    ){

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            types: $data['types'],
        );
    }
}
