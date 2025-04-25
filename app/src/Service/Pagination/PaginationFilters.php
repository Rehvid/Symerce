<?php

declare(strict_types=1);

namespace App\Service\Pagination;

final readonly class PaginationFilters
{
    public function __construct(
        public array $queryParams = [],
        public array $additionalData = []
    ) {}

    public function getSearch(): ?string
    {
        return $this->queryParams['search'] ?? null;
    }

    public function hasSearch(): bool
    {
        return $this->getSearch() !== null && trim($this->getSearch()) !== '';
    }

    public function getQueryParam(string $key): mixed
    {
        return $this->queryParams[$key] ?? null;
    }

    public function getAdditionalData(string $key): mixed
    {
        return $this->additionalData[$key] ?? null;
    }
}
