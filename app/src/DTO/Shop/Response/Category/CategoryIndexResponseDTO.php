<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Category;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class CategoryIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $name,
        public string $slug,
        public int $productCount,
        public ?string $imagePath = null
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            productCount: $data['productCount'],
            imagePath: $data['imagePath']
        );
    }
}
