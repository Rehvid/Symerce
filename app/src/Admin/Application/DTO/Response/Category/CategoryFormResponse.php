<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Category;

use App\DTO\Admin\Response\FileResponseDTO;

final readonly class CategoryFormResponse extends CategoryTreeResponse
{
    public function __construct(
        public ?string $name,
        public ?string $slug,
        public bool $isActive,
        public ?int $parentCategoryId = null,
        public ?string $description = null,
        public ?FileResponseDTO $image = null,
        array $tree
    ) {
        parent::__construct($tree);
    }
}
