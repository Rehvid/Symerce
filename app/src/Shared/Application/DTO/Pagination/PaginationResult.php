<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Pagination;

final readonly class PaginationResult
{
    public function __construct(
        public array $items,
        public PaginationMeta $paginationMeta
    ) {
    }
}
