<?php

declare (strict_types=1);

namespace App\Shared\Application\Filter;

use App\Shared\Application\Contract\FilterDefinitionInterface;
use App\Shared\Domain\Enums\QueryOperator;
use Symfony\Component\HttpFoundation\Request;

final readonly class BoolFilterDefinition implements FilterDefinitionInterface
{
    public function __construct(
        private string $field,
        private QueryOperator $operator,
        private ?array $requestNames = null
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getRequestNames(): array
    {
        return $this->requestNames ?? [$this->field];
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

    public function isMultiValue(): bool
    {
        return false;
    }

    public function castFromRequest(Request $request): mixed
    {
        return null;
    }
}
