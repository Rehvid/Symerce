<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Product;

use App\Shared\Application\Contract\SearchParserFactoryInterface;
use App\Shared\Application\Filter\BasicFilterDefinition;
use App\Shared\Application\Filter\BoolFilterDefinition;
use App\Shared\Application\Filter\RangeFilterDefinition;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Domain\Enums\QueryOperator;
use App\Shared\Infrastructure\Http\SearchFilterParser;
use App\Shared\Infrastructure\Http\SearchOrderByParser;
use App\Shared\Infrastructure\Http\SearchPaginationParser;

final readonly class ProductSearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        $allowedSortFields = ['id', 'name', 'quantity', 'isActive', 'discountPrice', 'regularPrice'];
        $allowedFilters = [
            new BoolFilterDefinition('isActive', QueryOperator::EQ),
            new BasicFilterDefinition('quantity', QueryOperator::EQ),
            new RangeFilterDefinition('regularPrice', 'regularPriceFrom','regularPriceTo'),
            new RangeFilterDefinition('discountPrice', 'discountPriceFrom','discountPriceTo'),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, ['search'])
        ];

        return new SearchRequestParser([
            new SearchOrderByParser($allowedSortFields),
            new SearchFilterParser($allowedFilters),
            new SearchPaginationParser(),
        ]);
    }
}
