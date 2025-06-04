<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Application\Builder\SearchCriteriaBuilder;
use App\Common\Application\Contracts\FilterDefinitionInterface;
use App\Common\Application\Contracts\RequestParserInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class SearchFilterParser implements RequestParserInterface
{
    public function __construct(
        /** @var FilterDefinitionInterface[] $filterDefinitions  */
        private array $filterDefinitions
    ) {}

    public function parse(Request $request, SearchCriteriaBuilder $builder): void
    {
        foreach ($this->filterDefinitions as $filterDefinition) {
            $this->parseFilterDefinition($filterDefinition, $request, $builder);
        }
    }

    private function parseFilterDefinition(
        FilterDefinitionInterface $filterDefinition,
        Request $request,
        SearchCriteriaBuilder $builder
    ): void {
        $field = $filterDefinition->getField();

        $value = $this->resolveValueFromRequest($filterDefinition, $request);

        if (null === $value) {
           return;
        }

        $builder->filter(
            $field,
            $filterDefinition->getOperator(),
            $value
        );
    }

    private function resolveValueFromRequest(FilterDefinitionInterface $filterDefinition, Request $request): mixed
    {
        $requestKeys = $filterDefinition->getRequestNames();

        $hasAny = array_filter($requestKeys, fn(string $key) => $request->get($key));
        if (empty($hasAny)) {
            return null;
        }

        if ($filterDefinition->isMultiValue()) {
            return $filterDefinition->castFromRequest($request);
        }

        $rawValue = $request->get($requestKeys[0]);
        return $filterDefinition->castValue($rawValue);
    }
}
