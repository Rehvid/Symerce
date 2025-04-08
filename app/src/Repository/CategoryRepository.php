<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class CategoryRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }

    protected function handlePaginatedQueryParams(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
