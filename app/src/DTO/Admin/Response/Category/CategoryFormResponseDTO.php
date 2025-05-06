<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Category;

use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class CategoryFormResponseDTO implements ResponseInterfaceData
{
    /** @param array<string,mixed> $tree */
    private function __construct(
        public array $tree,
        public ?string $name,
        public ?string $slug,
        public bool $isActive,
        public ?int $parentCategoryId = null,
        public ?string $description = null,
        public ?FileResponseDTO $image = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tree: $data['tree'] ?? [],
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
            isActive: $data['isActive'] ?? false,
            parentCategoryId: $data['parentCategoryId'] ?? null,
            description: $data['description'] ?? null,
            image: $data['image'] ?? null
        );
    }
}
