<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

use App\Common\Domain\Enums\DirectionType;

interface SearchDefinitionInterface
{
    /**
     * @return FilterDefinitionInterface[]
     */
    public function allowedFilters(): array;

    /**
     * @return string[]
     */
    public function allowedSortFields(): array;
}
