<?php

declare(strict_types=1);

namespace App\DTO\Response\AttributeValue;

use App\DTO\Response\ResponseInterfaceData;

final readonly class AttributeValueFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $value
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            value: $data['value']
        );
    }
}
