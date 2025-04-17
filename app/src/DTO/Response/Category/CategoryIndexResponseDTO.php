<?php

declare(strict_types=1);

namespace App\DTO\Response\Category;

use App\DTO\Response\ResponseInterfaceData;

final readonly class CategoryIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $imagePath = null,
    ) {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            slug: $data['slug'],
            imagePath: $data['imagePath'] ?? null,
        );
    }
}
