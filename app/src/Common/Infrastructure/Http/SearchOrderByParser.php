<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Application\Builder\SearchCriteriaBuilder;
use App\Common\Application\Contracts\RequestParserInterface;
use App\Common\Domain\Enums\DirectionType;
use Symfony\Component\HttpFoundation\Request;

final readonly class SearchOrderByParser implements RequestParserInterface
{
    private const string ORDER_BY_FIELD_SEPARATOR = '.';

    public function __construct(
        private array $allowedSortFields = [],
        private ?DirectionType $defaultDirection = null,
        private ?string $defaultSortField = null,
    ) {
    }

    public function parse(Request $request, SearchCriteriaBuilder $builder): void
    {
        $orderBy = $this->getOrderByValueFromRequest($request);
        $direction = $this->getDirectionValueFromRequest($request);

        if (null === $direction || null === $orderBy) {
            $this->sortByDefault($builder);
            return;
        }

        $builder->sortBy($orderBy, $direction);
    }

    private function getOrderByValueFromRequest(Request $request): ?string
    {
        $orderBy = $request->query->get('orderBy');

        if (null === $orderBy) {
            return null;
        }

        $orderByField = explode(self::ORDER_BY_FIELD_SEPARATOR, $orderBy);
        $value = $orderByField[0] ?? null;

        if (!in_array($value, $this->allowedSortFields, true)) {
            return null;
        }

        return $value;
    }

    private function getDirectionValueFromRequest(Request $request): ?DirectionType
    {
        $direction = $request->query->get('direction');
        if (null === $direction) {
            return null;
        }

        return DirectionType::tryFrom($direction);
    }

    private function sortByDefault(SearchCriteriaBuilder $builder): void
    {
        if (null === $this->defaultDirection || null === $this->defaultSortField) {
            return;
        }

        $builder->sortBy($this->defaultSortField, $this->defaultDirection);
    }
}
