<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Shop\Response;

final readonly class CategorySubcategoryListResponse
{
    public function __construct(
        public string $name,
        public string $href,
        public ?string $image
    ) {
    }
}
