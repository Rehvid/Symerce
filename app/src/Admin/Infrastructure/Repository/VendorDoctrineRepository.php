<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Entity\Vendor;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class VendorDoctrineRepository extends AbstractRepository implements VendorRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

    protected function getEntityClass(): string
    {
        return Vendor::class;
    }

    protected function getAlias(): string
    {
        return 'vendor';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());
        $filterBuilder->applyIsActive();

        return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
    }
}
