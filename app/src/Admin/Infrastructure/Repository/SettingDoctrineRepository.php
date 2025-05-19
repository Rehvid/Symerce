<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class SettingDoctrineRepository extends AbstractRepository implements SettingRepositoryInterface
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
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->where("$alias.type NOT IN (:excludedTypes)")
            ->setParameter('excludedTypes', $excludedTypes)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Setting[]
     */
    public function findAllMetaSettings(): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->where("$alias.type IN (:types)")
            ->andWhere("$alias.isActive = :active")
            ->setParameter('types', SettingType::getMetaTypes())
            ->setParameter('active', true)
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
