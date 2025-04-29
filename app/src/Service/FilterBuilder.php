<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

final readonly class FilterBuilder
{
    public function __construct(
        private QueryBuilder $queryBuilder,
        private PaginationFilters $filters,
        private string $alias
    ) {
    }

    public function applyIsActive(): self
    {
        $isActive = $this->filters->getQueryParam('isActive');
        if (null !== $isActive) {
            $this->queryBuilder->andWhere(sprintf('%s.isActive = :isActive', $this->alias))
                ->setParameter('isActive', $this->filters->getBooleanQueryParam('isActive'));
        }

        return $this;
    }

    public function applyBetweenValue(
        string $column
    ): self {
        $from = $this->filters->getQueryParam(sprintf('%sFrom', $column));
        $to = $this->filters->getQueryParam(sprintf('%sTo', $column));

        $entityColumn = $this->getEntityColumn($column);
        if (null !== $from && null !== $to) {
            $this->queryBuilder
                ->andWhere("$entityColumn BETWEEN :from AND :to")
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        } elseif (null !== $from) {
            $this->queryBuilder
                ->andWhere("$entityColumn >= :from")
                ->setParameter('from', $from);
        } elseif (null !== $to) {
            $this->queryBuilder
                ->andWhere("$entityColumn <= :to")
                ->setParameter('to', $to);
        }

        return $this;
    }

    public function applyExactValue(string $column): self
    {
        $entityColumn = $this->getEntityColumn($column);
        $value = $this->filters->getQueryParam($column);
        if (null !== $value) {
            $this->queryBuilder->andWhere("$entityColumn = :value")
                ->setParameter('value', $value);
        }

        return $this;
    }

    private function getEntityColumn(string $column): string
    {
        return sprintf('%s.%s', $this->alias, $column);
    }
}
