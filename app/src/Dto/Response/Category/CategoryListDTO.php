<?php

namespace App\Dto\Response\Category;

use App\Dto\Response\ResponseInterfaceData;

final readonly class CategoryListDTO implements ResponseInterfaceData
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
