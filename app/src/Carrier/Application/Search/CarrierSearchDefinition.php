<?php

declare(strict_types=1);

namespace App\Carrier\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\BoolFilterDefinition;
use App\Common\Application\Search\Filter\RangeFilterDefinition;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CarrierSearchDefinition implements SearchDefinitionInterface
{

    /**
     * @inheritDoc
     */
    public function allowedFilters(): array
    {
        return [
            new BoolFilterDefinition('isActive', QueryOperator::EQ),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search'),
            new RangeFilterDefinition('fee', 'feeFrom', 'feeTo'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function allowedSortFields(): array
    {
        return ['id', 'name', 'isActive', 'fee'];
    }
}
