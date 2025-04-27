<?php

namespace App\Repository;

use App\Entity\DeliveryTime;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class DeliveryTimeRepository extends AbstractRepository
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
        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        $alias = $this->getAlias();
        return $queryBuilder->orderBy("$alias." . OrderByField::ORDER->value , DirectionType::ASC->value);
    }
}
