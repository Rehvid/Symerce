<?php

declare(strict_types=1);

namespace App\Cart\Application\Search;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\DirectionType;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class CartSearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name'];
        $allowedFilters = [
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search']),
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields, DirectionType::ASC, 'id'),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
