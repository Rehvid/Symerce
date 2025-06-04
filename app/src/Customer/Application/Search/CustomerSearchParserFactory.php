<?php

declare(strict_types=1);

namespace App\Customer\Application\Search;

use App\Common\Application\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Filter\BasicFilterDefinition;
use App\Common\Application\Parser\SearchRequestParser;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;
use App\Common\Infrastructure\Http\SearchFilterParser;
use App\Common\Infrastructure\Http\SearchOrderByParser;
use App\Common\Infrastructure\Http\SearchPaginationParser;

final readonly class CustomerSearchParserFactory implements SearchParserFactoryInterface
{
    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'email', 'isActive'];
        $allowedFilters = [
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search']),
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields, DirectionType::DESC, 'id'),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
