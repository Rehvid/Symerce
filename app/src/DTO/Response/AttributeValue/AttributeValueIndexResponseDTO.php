<?php

declare(strict_types=1);

namespace App\DTO\Response\AttributeValue;

use App\DTO\Response\ResponseInterfaceData;

final readonly class AttributeValueIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $value
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            value: $data['value']
        );
    }
}
