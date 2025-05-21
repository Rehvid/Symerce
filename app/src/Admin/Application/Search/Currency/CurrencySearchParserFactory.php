<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Currency;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Filter\RangeFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class CurrencySearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name', 'roundingPrecision', 'symbol', 'code'];
        $allowedFilters = [
            new RangeFilterDefinition('roundingPrecision', 'roundingPrecisionFrom', 'roundingPrecisionTo'),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search']),
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
