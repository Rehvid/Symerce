<?php

declare(strict_types=1);

namespace App\Currency\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\RangeFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CurrencySearchDefinition implements SearchDefinitionInterface
{
    public function allowedFilters(): array
    {
        return  [
            new RangeFilterDefinition(
                'roundingPrecision',
                'roundingPrecisionFrom',
                'roundingPrecisionTo'
            ),
            new BasicFilterDefinition('name', QueryOperator::LIKE, 'search'),
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'name', 'roundingPrecision', 'symbol', 'code'];
    }
}
