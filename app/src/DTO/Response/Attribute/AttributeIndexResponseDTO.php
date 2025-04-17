<?php

declare(strict_types=1);

namespace App\DTO\Response\Attribute;

use App\DTO\Response\ResponseInterfaceData;

final readonly class AttributeIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name']
        );
    }
}
