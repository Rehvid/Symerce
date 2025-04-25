<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Repository\Base\PaginationRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class ProductRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'p';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder->orderBy("$alias.order", 'ASC');
    }
}
