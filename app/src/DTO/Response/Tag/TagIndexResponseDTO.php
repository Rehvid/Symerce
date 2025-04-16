<?php

namespace App\DTO\Response\Tag;

use App\DTO\Response\ResponseInterfaceData;

class TagIndexResponseDTO implements ResponseInterfaceData
{

    private function __construct(
        public int $id,
        public string $name,
    ){}

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
