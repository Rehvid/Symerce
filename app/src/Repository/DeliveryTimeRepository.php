<?php

namespace App\Repository;

use App\Entity\DeliveryTime;
use App\Repository\Base\PaginationRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class DeliveryTimeRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return DeliveryTime::class;
    }

    protected function getAlias(): string
    {
        return 'delivery_time';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder->orderBy("$alias.order", 'ASC');
    }
}
