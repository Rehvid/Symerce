<?php

declare(strict_types=1);

namespace App\Order\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\RangeFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class OrderSearchDefinition implements SearchDefinitionInterface
{
    public function allowedFilters(): array
    {
        return [
            new BasicFilterDefinition('type', QueryOperator::EQ),
            new RangeFilterDefinition('createdAt', 'createdAtFrom', 'createdAtTo'),
            new RangeFilterDefinition('updatedAt', 'updatedAtFrom', 'updatedAtTo'),
            new BasicFilterDefinition('name', QueryOperator::LIKE, 'search'),
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'status', 'checkoutStep', 'createdAt', 'updatedAt', 'totalPrice'];
    }
}
