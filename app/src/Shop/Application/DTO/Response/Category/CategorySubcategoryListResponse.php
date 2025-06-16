<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Response\Category;

final readonly class CategorySubcategoryListResponse
{
    public function __construct(
        public string $name,
        public string $href,
        public ?string $image
    ) {
    }
}
