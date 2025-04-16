<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class TagRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
        return Tag::class;
    }

    protected function getAlias(): string
    {
        return 'tag';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
