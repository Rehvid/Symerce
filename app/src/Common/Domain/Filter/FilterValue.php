<?php

declare(strict_types=1);

namespace App\Common\Domain\Filter;

use App\Common\Application\Search\Contracts\FilterDefinitionInterface;

final readonly class FilterValue
{
    public function __construct(
        public FilterDefinitionInterface $definition,
        public mixed $value
    ) {
    }
}
