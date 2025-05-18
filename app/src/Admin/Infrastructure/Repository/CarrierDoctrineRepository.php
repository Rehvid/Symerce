<?php

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Entity\Carrier;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CarrierDoctrineRepository extends AbstractRepository implements CarrierRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

    /** @return array<int, mixed> */
    public function findLowestAndHighestFee(): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->select("MAX($alias.fee) as maxFee, MIN($alias.fee) as minFee")
            ->andWhere("$alias.isActive = :active")
            ->setParameter("active", true)
            ->getQuery()
            ->getSingleResult();
    }

    protected function getEntityClass(): string
    {
        return Carrier::class;
    }

    protected function getAlias(): string
    {
        return 'carrier';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());

        $filterBuilder
            ->applyIsActive()
            ->applyBetweenValue('fee');

        return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
    }
}
