<?php

namespace App\Repository;

use App\Entity\DeliveryTime;
use App\Repository\Base\PaginationRepository;
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

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
