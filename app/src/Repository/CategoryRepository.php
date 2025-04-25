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

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = [], array $additionalData = []): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder
            ->select("$alias.id, $alias.name, $alias.slug, $alias.isActive, image.path")
            ->leftJoin("$alias.image", 'image')
            ->orderBy("$alias.order", 'ASC')
        ;
    }
}
