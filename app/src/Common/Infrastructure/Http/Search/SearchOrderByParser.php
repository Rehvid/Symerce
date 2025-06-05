<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http\Search;

use App\Common\Application\Search\Builder\SearchCriteriaBuilder;
use App\Common\Application\Search\Contracts\SearchParserInterface;
use App\Common\Application\Search\Dto\SearchData;
use App\Common\Domain\Enums\DirectionType;


final readonly class SearchOrderByParser implements SearchParserInterface
{

    public function __construct(
        private ?DirectionType $defaultDirection = null,
        private ?string $defaultSortField = null,
    ) {
    }

    public function parse(SearchData $data, SearchCriteriaBuilder $builder): void
    {
        $orderBy = $data->sortBy;
        $direction = $data->directionType;

        if (null === $direction || null === $orderBy) {
            $this->sortByDefault($builder);
            return;
        }

        $builder->sortBy($orderBy, $direction);
    }

    private function sortByDefault(SearchCriteriaBuilder $builder): void
    {
        if (null === $this->defaultDirection || null === $this->defaultSortField) {
            return;
        }

        $builder->sortBy($this->defaultSortField, $this->defaultDirection);
    }
}
