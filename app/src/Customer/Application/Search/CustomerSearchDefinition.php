<?php

declare(strict_types=1);

namespace App\Customer\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CustomerSearchDefinition implements SearchDefinitionInterface
{
    public function allowedFilters(): array
    {
        return [
            new BasicFilterDefinition('name', QueryOperator::LIKE, 'search'),
        ];
    }

    public function allowedSortFields(): array
    {
        return ['id', 'email', 'isActive'];
    }
}
