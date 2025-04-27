<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class CategoryRepository extends AbstractRepository
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        $alias = $this->getAlias();
        return $queryBuilder->orderBy("$alias." . OrderByField::ORDER->value , DirectionType::ASC->value);
    }
}
