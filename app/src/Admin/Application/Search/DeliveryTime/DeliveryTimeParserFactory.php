<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\DeliveryTime;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Filter\RangeFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class DeliveryTimeParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name', 'minDays', 'maxDays', 'isActive', 'type'];
        $allowedFilters = [
            new BasicFilterDefinition('type', QueryOperator::EQ),
            new RangeFilterDefinition('minDays', 'minDaysFrom','minDaysTo'),
            new RangeFilterDefinition('maxDays', 'maxDaysFrom','maxDaysTo'),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search'])
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
