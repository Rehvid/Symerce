<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\AttributeValue;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\DirectionType;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class AttributeSearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'value'];
        $allowedFilters = [
            new BasicFilterDefinition('value',  QueryOperator::LIKE, ['search']),
            new BasicFilterDefinition('attribute', QueryOperator::EQ, ['attributeId'])
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields, DirectionType::ASC, 'position'),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
