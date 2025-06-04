<?php

declare (strict_types = 1);

namespace App\Carrier\Application\Search;

use App\Common\Application\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Filter\BasicFilterDefinition;
use App\Common\Application\Filter\BoolFilterDefinition;
use App\Common\Application\Filter\RangeFilterDefinition;
use App\Common\Application\Parser\SearchRequestParser;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;
use App\Common\Infrastructure\Http\SearchFilterParser;
use App\Common\Infrastructure\Http\SearchOrderByParser;
use App\Common\Infrastructure\Http\SearchPaginationParser;

final readonly class CarrierSearchFactoryParser implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name', 'isActive', 'fee'];
        $allowedFilters = [
            new BoolFilterDefinition('isActive', QueryOperator::EQ),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search']),
            new RangeFilterDefinition('fee', 'feeFrom', 'feeTo'),
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields, DirectionType::ASC, 'id'),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
