<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http\Search;

use App\Common\Application\Search\Builder\SearchCriteriaBuilder;
use App\Common\Application\Search\Dto\SearchData;

final readonly class SearchPaginationParser
{
    public function parse(SearchData $data, SearchCriteriaBuilder $builder): void
    {
        $builder->paginate(
            limit: $data->limit,
            offset: $data->offset,
            page: $data->page,
        );
    }
}
