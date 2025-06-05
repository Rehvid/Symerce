<?php

declare(strict_types=1);

namespace App\Tag\Application\Search;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;

final readonly class TagSearchDefinition implements SearchDefinitionInterface
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
