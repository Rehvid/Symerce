<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Setting;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class SettingRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

    protected function getEntityClass(): string
    {
        return Setting::class;
    }

    protected function getAlias(): string
    {
        return 'global_settings';
    }

    /**
     * @param array<int, mixed> $excludedTypes
     *
     * @return Setting[]
     */
    public function findAllExcludingTypes(array $excludedTypes): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.type NOT IN (:excludedTypes)')
            ->setParameter('excludedTypes', $excludedTypes)
            ->getQuery()
            ->getResult();
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());
        $filterBuilder
            ->applyExactValue('type')
        ;

        return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
    }
}
