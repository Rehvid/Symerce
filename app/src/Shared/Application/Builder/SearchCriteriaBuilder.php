<?php

declare(strict_types=1);

namespace App\Shared\Application\Builder;

use App\Shared\Application\DTO\Filter\FilterCondition;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Domain\Enums\DirectionType;
use App\Shared\Domain\Enums\QueryOperator;

final class SearchCriteriaBuilder
{
    private array $filters = [];
    private ?string $sortField = null;
    private DirectionType $sortDirection = DirectionType::ASC;
    private int $limit = 0;
    private int $offset = 0;

    private int $page = 1;

    public function filter(string $field, QueryOperator $operator, mixed $value): self
    {
        $this->filters[] = new FilterCondition($field, $operator, $value);

        return $this;
    }

    public function sortBy(string $field, DirectionType $sortDirection = DirectionType::ASC): self
    {
        $this->sortField     = $field;
        $this->sortDirection = $sortDirection;

        return $this;
    }

    public function paginate(int $limit, int $offset, int $page): self
    {
        $this->limit  = $limit;
        $this->offset = $offset;
        $this->page = $page;

        return $this;
    }

    public function build(): SearchCriteria
    {
        return new SearchCriteria(
            filters:       $this->filters,
            sortField:     $this->sortField,
            sortDirection: $this->sortDirection,
            limit:         $this->limit,
            offset:        $this->offset,
        );
    }
}
