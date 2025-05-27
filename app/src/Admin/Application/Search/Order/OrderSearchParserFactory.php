<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Order;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Filter\RangeFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\DirectionType;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class OrderSearchParserFactory implements SearchParserFactoryInterface
{
    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'status', 'checkoutStep', 'createdAt', 'updatedAt', 'totalPrice'];
        $allowedFilters = [
            new BasicFilterDefinition('type', QueryOperator::EQ),
            new RangeFilterDefinition('createdAt', 'createdAtFrom','createdAtTo'),
            new RangeFilterDefinition('updatedAt', 'updatedAtFrom','updatedAtTo'),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search'])
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields, DirectionType::DESC, 'id'),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
