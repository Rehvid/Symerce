<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

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
