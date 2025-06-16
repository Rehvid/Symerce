<?php

declare(strict_types=1);

namespace App\Category\Application\Dto;

use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\Category;

final readonly class CategoryData
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public Category $parentCategory,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public ?string $slug,
        public ?string $description,
        public ?FileData $fileData,
    ) {
    }
}
