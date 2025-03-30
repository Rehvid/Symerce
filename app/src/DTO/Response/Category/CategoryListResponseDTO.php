<?php

namespace App\DTO\Response\Category;

use App\DTO\Response\ResponseInterfaceData;

final readonly class CategoryListResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $description
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description']
        );
    }
}
