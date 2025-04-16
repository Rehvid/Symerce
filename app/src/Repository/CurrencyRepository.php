<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class CurrencyRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
       return Currency::class;
    }

    protected function getAlias(): string
    {
        return 'currency';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
