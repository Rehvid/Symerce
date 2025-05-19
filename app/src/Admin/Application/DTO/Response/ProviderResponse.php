<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Shared\Domain\Enums\SettingType;

class ProviderResponse implements ResponseInterfaceData
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
