<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Pagination;

final class PaginationMeta
{
    public function __construct(
        private int $page,
        private readonly int $limit,
        private readonly int $offset,
        private int $totalItems = 0,
        private int $totalPages = 0,
    ) {
    }

    public function setTotalItems(int $totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /** @return array<string, mixed> */
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
