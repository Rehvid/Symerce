<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Response\Category;

final readonly class CategoryListResponse
{
    public function __construct(
        public string $name,
        public string $slug,
        public int $productCount,
        public ?string $imagePath = null
    ) {
    }
}
