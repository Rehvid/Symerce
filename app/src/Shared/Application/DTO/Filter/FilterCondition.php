<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Filter;

use App\Shared\Domain\Enums\QueryOperator;

final readonly class FilterCondition
{
    public function __construct(
       public string $field,
       public QueryOperator $queryOperator,
       public mixed $value,
    ) {}
}
