<?php

declare(strict_types=1);

namespace App\Category\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Filter\BoolFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CategorySearchDefinition implements SearchDefinitionInterface
{

    /**
     * @inheritDoc
     */
    public function allowedFilters(): array
    {
        return [
            new BoolFilterDefinition('isActive', QueryOperator::EQ),
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function allowedSortFields(): array
    {
        return ['id', 'name', 'quantity', 'isActive', 'slug'];
    }
}
