<?php

namespace App\Service\Pagination;

final readonly class PaginationMeta
{
    public function __construct(
        public int $page,
        public int $limit,
        public int $totalItems,
        public int $totalPages,
        public int $offset
    ) {
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
            'totalItems' => $this->totalItems,
            'totalPages' => $this->totalPages,
            'offset' => $this->offset,
        ];
    }
}
