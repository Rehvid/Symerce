<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\FilterBuilder;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry                $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

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
        $alias = $this->getAlias();

        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $alias);
        $filterBuilder->applyIsActive();

        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        return $queryBuilder->orderBy("$alias." . OrderByField::ORDER->value , DirectionType::ASC->value);
    }
}
