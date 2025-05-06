<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Tag;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class TagFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $name,
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
        );
    }
}
