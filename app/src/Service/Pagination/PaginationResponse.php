<?php

namespace App\Service\Pagination;

final readonly class PaginationResponse
{
    public function __construct(
        public array $data,
        public PaginationMeta $paginationMeta,
    ) {
    }
}
