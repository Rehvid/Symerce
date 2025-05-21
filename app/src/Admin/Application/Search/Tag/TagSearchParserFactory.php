<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Tag;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class TagSearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name'];
        $allowedFilters = [
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search']),
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
