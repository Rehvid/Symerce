<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http\Search;

use App\Common\Application\Search\Builder\SearchCriteriaBuilder;
use App\Common\Application\Search\Contracts\SearchParserInterface;
use App\Common\Application\Search\Dto\SearchData;
use App\Common\Domain\Filter\FilterValue;

final readonly class SearchFilterParser implements SearchParserInterface
{
    public function parse(SearchData $data, SearchCriteriaBuilder $builder): void
    {
        foreach ($data->filters as $filter) {
            $this->parseFilterValue($filter, $builder);
        }
    }

    private function parseFilterValue(
        FilterValue $filterValue,
        SearchCriteriaBuilder $builder
    ): void {
        $builder->filter(
            $filterValue->definition->getField(),
            $filterValue->definition->getOperator(),
            $filterValue->value
        );
    }
}
