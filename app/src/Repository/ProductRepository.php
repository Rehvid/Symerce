<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

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
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());
        $filterBuilder
            ->applyIsActive()
            ->applyExactValue('quantity')
            ->applyBetweenValue('regularPrice')
            ->applyBetweenValue('discountPrice')
        ;

        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        $alias = $this->getAlias();

        return $queryBuilder->orderBy("$alias.".OrderByField::ORDER->value, DirectionType::ASC->value);
    }
}
