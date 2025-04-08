<?php

namespace App\Service\Pagination;

final readonly class PaginationResponse
{
    /**
     * @param array<int, mixed> $data
     */
    public function __construct(
        public array $data,
        public PaginationMeta $paginationMeta,
    ) {
    }
}
