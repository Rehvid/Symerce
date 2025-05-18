<?php

declare (strict_types = 1);

namespace App\Admin\Application\DTO\Response\Category;

readonly class CategoryTreeResponse
{

    /** @param array<string,mixed> $tree */
    public function __construct(
        public array $tree,
    ) {
    }
}
