<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Pagination;

final readonly class PaginationResult
{
    public function __construct(
        public array $items,
        public PaginationMeta $paginationMeta
    ) {
    }
}
