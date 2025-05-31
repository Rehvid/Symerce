<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Response;

final readonly class CategoryListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public bool $isActive,
        public ?string $imagePath = null,
    ) {
    }
}
