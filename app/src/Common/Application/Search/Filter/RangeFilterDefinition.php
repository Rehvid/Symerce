<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Filter;

use App\Common\Application\Search\Contracts\FilterMultiDefinitionInterface;
use App\Common\Domain\Enums\QueryOperator;


final readonly class RangeFilterDefinition implements FilterMultiDefinitionInterface
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

    public function castValues(array $rawValues): array
    {
        $returnValues = [
            'from' => null,
            'to' => null
        ];


        foreach ($rawValues as $key => $rawValue) {
            $rawValue = trim((string) $rawValue);
            if ('' === $rawValue) {
                continue;
            }

            if ($key === $this->requestNameFrom) {
                $returnValues['from'] = $rawValue;
            } elseif ($key === $this->requestNameTo) {
                $returnValues['to'] = $rawValue;
            }
        }

        return $returnValues;
    }
}
