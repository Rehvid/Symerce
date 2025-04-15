<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attribute;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class AttributeRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
        return Attribute::class;
    }

    protected function getAlias(): string
    {
        return 'attribute';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
