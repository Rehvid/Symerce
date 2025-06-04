<?php

declare(strict_types=1);

namespace App\Common\Application\Filter;

use App\Common\Application\Contracts\FilterDefinitionInterface;
use App\Common\Domain\Enums\QueryOperator;
use Symfony\Component\HttpFoundation\Request;

final readonly class RangeFilterDefinition implements FilterDefinitionInterface
{
    public function __construct(
        private string $field,
        private string $requestNameFrom,
        private string $requestNameTo,
    )
    {}

    public function getRequestNames(): array
    {
        return [$this->requestNameFrom, $this->requestNameTo];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOperator(): QueryOperator
    {
        return QueryOperator::BETWEEN;
    }

    public function castValue(mixed $rawValue): mixed
    {
        return null;
    }

    public function isMultiValue(): bool
    {
        return true;
    }

    public function castFromRequest(Request $request): mixed
    {
        return [
            'from' => $request->query->get($this->requestNameFrom),
            'to' => $request->query->get($this->requestNameTo),
        ];
    }
}
