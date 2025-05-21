<?php

declare(strict_types=1);

namespace App\Shared\Application\Filter;

use App\Shared\Application\Contract\FilterDefinitionInterface;
use App\Shared\Domain\Enums\QueryOperator;
use Symfony\Component\HttpFoundation\Request;

final readonly class BasicFilterDefinition implements FilterDefinitionInterface
{
    public function __construct(
        private string $field,
        private QueryOperator $operator,
        private ?array $requestNames = null,
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

    public function castValue(mixed $rawValue): mixed
    {
        return $rawValue;
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
