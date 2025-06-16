<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Dto;

use App\Common\Domain\Enums\QueryOperator;

final readonly class FilterCondition
{
    public function __construct(
        public string $field,
        public QueryOperator $queryOperator,
        public mixed $value,
    ) {
    }
}
