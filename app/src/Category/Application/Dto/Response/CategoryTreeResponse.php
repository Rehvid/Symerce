<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Response;

readonly class CategoryTreeResponse
{
    /** @param array<string,mixed> $tree */
    public function __construct(
        public array $tree,
    ) {
    }
}
