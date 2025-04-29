<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry                $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

    protected function getEntityClass(): string
    {
        return Currency::class;
    }

    protected function getAlias(): string
    {
        return 'currency';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());
        $filterBuilder
            ->applyBetweenValue('roundingPrecision')
        ;

        return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
    }
}
