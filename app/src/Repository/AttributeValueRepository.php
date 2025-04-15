<?php

declare (strict_types=1);

namespace App\Repository;

use App\Entity\AttributeValue;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class AttributeValueRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
        return AttributeValue::class;
    }

    protected function getAlias(): string
    {
        return "attribute_value";
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
