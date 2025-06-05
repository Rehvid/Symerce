<?php

declare(strict_types=1);

namespace App\Product\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\BoolFilterDefinition;
use App\Common\Application\Search\Filter\RangeFilterDefinition;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;

final class ProductSearchDefinition implements SearchDefinitionInterface
{
    public function allowedFilters(): array
    {
       return [
            new BoolFilterDefinition('isActive', QueryOperator::EQ),
            new BasicFilterDefinition('quantity', QueryOperator::EQ),
            new RangeFilterDefinition('regularPrice', 'regularPriceFrom','regularPriceTo'),
            new RangeFilterDefinition('discountPrice', 'discountPriceFrom','discountPriceTo'),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search')
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'name', 'quantity', 'isActive', 'discountPrice', 'regularPrice'];
    }
}
