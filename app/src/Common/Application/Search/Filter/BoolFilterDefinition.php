<?php

declare (strict_types=1);

namespace App\Common\Application\Search\Filter;

use App\Common\Application\Search\Contracts\FilterDefinitionInterface;
use App\Common\Application\Search\Contracts\FilterSingleDefinitionInterface;
use App\Common\Domain\Enums\QueryOperator;

final readonly class BoolFilterDefinition implements FilterSingleDefinitionInterface
{
    public function __construct(
        private string $field,
        private QueryOperator $operator,
        private ?string $requestName = null,
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getRequestName(): string
    {
        return $this->requestName ?? $this->field;
    }

    public function getOperator(): QueryOperator
    {
        return $this->operator;
    }

    public function castValue(mixed $rawValue): bool
    {
        $castedValue = filter_var(
            $rawValue,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        if (null === $castedValue) {
            throw new \InvalidArgumentException(
                sprintf("Invalid boolean for '%s': %s", $this->field, $rawValue)
            );
        }

        return $castedValue;
    }
}
