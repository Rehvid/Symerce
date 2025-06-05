<?php

declare(strict_types=1);

namespace App\Cart\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Domain\Enums\QueryOperator;

final readonly class CartSearchDefinition implements SearchDefinitionInterface
{

    /**
     * @inheritDoc
     */
    public function allowedFilters(): array
    {
        return [
            new BasicFilterDefinition('name',  QueryOperator::LIKE, 'search'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function allowedSortFields(): array
    {
        return ['id', 'name'];
    }
}
