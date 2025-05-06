<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;

class SettingFormResponseDTO implements ResponseInterfaceData
{
    /** @param array<int, mixed>  $types */
    protected function __construct(
        public array $types,
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            types: $data['types'],
        );
    }
}
