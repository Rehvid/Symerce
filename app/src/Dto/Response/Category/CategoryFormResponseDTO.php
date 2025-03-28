<?php

declare(strict_types=1);

namespace App\Dto\Response\Category;

use App\Dto\Response\ResponseInterfaceData;

final readonly class CategoryFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public array $tree,
        public ?string $name,
        public ?int $parentCategoryId = null,
        public ?string $description = null,
        public bool $isActive,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            tree: $data['tree'] ?? [],
            name: $data['name'] ?? null,
            parentCategoryId: $data['parentCategoryId'] ?? null,
            description: $data['description'] ?? null,
            isActive: $data['isActive'] ?? false,
        );
    }
}
