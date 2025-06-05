<?php

declare(strict_types=1);

namespace App\Currency\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\RangeFilterDefinition;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CurrencySearchDefinition implements SearchDefinitionInterface
{

    /**
     * @inheritDoc
     */
    public function allowedFilters(): array
    {
        return  [
            new RangeFilterDefinition(
                'roundingPrecision',
                'roundingPrecisionFrom',
                'roundingPrecisionTo'
            ),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function allowedSortFields(): array
    {
        return ['id', 'name', 'roundingPrecision', 'symbol', 'code'];
    }

    public function defaultSortBy(): string
    {
        // TODO: Implement defaultSortBy() method.
    }

    public function defaultSortDirection(): DirectionType
    {
        // TODO: Implement defaultSortDirection() method.
    }
}
