<?php

declare (strict_types = 1);

namespace App\DTO\Response\Attribute;

use App\DTO\Response\ResponseInterfaceData;

final readonly class AttributeFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
       public readonly string $name,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
        );
    }
}
