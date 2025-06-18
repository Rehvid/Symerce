<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Shop\Response;

final readonly class CategoryListResponseCollection
{
    /** @param CategoryListResponse[] $categories */
    public function __construct(
        public array $categories,
    ) {}
}
