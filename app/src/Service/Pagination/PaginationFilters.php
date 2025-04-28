<?php

declare(strict_types=1);

namespace App\Service\Pagination;

use App\Enums\DirectionType;
use App\Enums\OrderByField;

final readonly class PaginationFilters
{
    private const string ORDER_BY_FIELD_SEPARATOR = '.';

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

    public function getBooleanQueryParam(string $key): bool
    {
        $value = $this->getQueryParam($key);
        if ($value === null) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    public function getAdditionalData(string $key): mixed
    {
        return $this->additionalData[$key] ?? null;
    }

    public function hasOrderBy(): bool
    {
        return $this->getOrderBy() !== null && $this->getDirection() !== null;
    }

    public function getOrderBy(): ?OrderByField
    {
        $orderBy = $this->getQueryParam('orderBy');
        if (null === $orderBy) {
            return null;
        }
        $orderByField = explode(self::ORDER_BY_FIELD_SEPARATOR, $orderBy);

        return OrderByField::tryFrom($orderByField[0] ?? null);
    }

    public function getDirection(): ?DirectionType
    {
        $direction = $this->getQueryParam('direction');
        if (null === $direction) {
            return null;
        }

        return DirectionType::tryFrom($direction);
    }
}
