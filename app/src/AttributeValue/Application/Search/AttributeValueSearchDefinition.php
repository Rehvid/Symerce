<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class AttributeValueSearchDefinition implements SearchDefinitionInterface
{
    public function allowedFilters(): array
    {
        return [
            new BasicFilterDefinition('value', QueryOperator::LIKE, 'search'),
            new BasicFilterDefinition('attribute', QueryOperator::EQ, 'attributeId'),
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'value'];
    }
}
