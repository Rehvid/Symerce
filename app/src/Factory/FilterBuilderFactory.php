<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\FilterBuilder;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

final class FilterBuilderFactory
{
    public function create(QueryBuilder $queryBuilder, PaginationFilters $filters, string $alias): FilterBuilder
    {
        return new FilterBuilder($queryBuilder, $filters, $alias);
    }
}
