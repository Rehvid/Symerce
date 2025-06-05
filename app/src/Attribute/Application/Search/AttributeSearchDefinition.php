<?php

declare(strict_types=1);

namespace App\Attribute\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;

final class AttributeSearchDefinition implements SearchDefinitionInterface
{

    public function allowedFilters(): array
    {
        return [
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search'),
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'name'];
    }

    public function defaultSortBy(): string
    {
        return 'position';
    }

    public function defaultSortDirection(): DirectionType
    {
        return DirectionType::ASC;
    }
}
