<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;

class SettingShopCategoryDTOResponse implements ResponseInterfaceData
{
    private function __construct(
        public string $name,
        public string $url
    ) {}

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
            url: $data['url'],
        );
    }
}
