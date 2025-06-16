<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Extractor;

use App\Common\Application\Search\Contracts\FilterDefinitionInterface;
use App\Common\Application\Search\Contracts\FilterMultiDefinitionInterface;
use App\Common\Application\Search\Contracts\FilterSingleDefinitionInterface;
use App\Common\Domain\Filter\FilterValue;
use Symfony\Component\HttpFoundation\Request;

final readonly class FilterExtractor
{
    /**
     * @param FilterDefinitionInterface[] $allowedFilters
     *
     * @return FilterValue[]
     */
    public function extract(Request $request, array $allowedFilters): array
    {
        $filterValues = [];

        foreach ($allowedFilters as $filterDefinition) {
            $value = null;
            if ($filterDefinition instanceof FilterSingleDefinitionInterface) {
                $value = $this->extractSingleValue($filterDefinition, $request);
            } elseif ($filterDefinition instanceof FilterMultiDefinitionInterface) {
                $value = $this->extractMultiValue($filterDefinition, $request);
            }

            if (null === $value) {
                continue;
            }

            $filterValues[] = $value;
        }

        return $filterValues;
    }

    private function extractSingleValue(
        FilterSingleDefinitionInterface $definition,
        Request $request,
    ): ?FilterValue {
        $rawValue = $request->get($definition->getRequestName());

        if (null === $rawValue) {
            return null;
        }

        $rawValue = trim($rawValue);
        if ('' === $rawValue) {
            return null;
        }

        return new FilterValue(
            definition: $definition,
            value: $definition->castValue($rawValue)
        );
    }

    private function extractMultiValue(FilterMultiDefinitionInterface $definition, Request $request): ?FilterValue
    {
        $requestKeys = $definition->getRequestNames();

        $hasAny = array_filter($requestKeys, fn (string $key) => null !== $request->get($key));
        if (empty($hasAny)) {
            return null;
        }

        $multiValues = [];
        foreach ($definition->getRequestNames() as $name) {
            $multiValues[$name] = $request->get($name);
        }

        return new FilterValue(
            definition: $definition,
            value: $definition->castValues($multiValues)
        );
    }
}
