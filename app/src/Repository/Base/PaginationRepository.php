<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\Pagination\PaginationFilters;
use App\Service\Pagination\PaginationMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/** @phpstan-ignore-next-line */
abstract class PaginationRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{
    abstract protected function getEntityClass(): string;

    abstract protected function getAlias(): string;

    /**
     * @param array<string, mixed> $queryParams
     */
    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        return $queryBuilder;
    }

    public function __construct(ManagerRegistry $registry)
    {
        /* @phpstan-ignore-next-line */
        parent::__construct($registry, $this->getEntityClass());
    }

    public function findPaginated(PaginationMeta $paginationMeta, PaginationFilters $paginationFilters): array
    {

        $alias = $this->getAlias();

        $baseQueryBuilder = $this->createQueryBuilder($alias);

        if ($paginationFilters->hasSearch()) {
            $search = $paginationFilters->getSearch();
            $baseQueryBuilder
                ->andWhere("$alias.name LIKE :search")
                ->setParameter('search', "%$search%")
            ;
        }

        $this->configureQueryForPagination($baseQueryBuilder, $paginationFilters);

        $countQueryBuilder = clone ($baseQueryBuilder);
        $countQueryBuilder->select("COUNT($alias.id)");

        $total = (int) $countQueryBuilder->getQuery()->getSingleScalarResult();

        $baseQueryBuilder
            ->setFirstResult($paginationMeta->getOffset())
            ->setMaxResults($paginationMeta->getLimit());

        $items = $baseQueryBuilder->getQuery()->getResult();

        return [
            'items' => $items,
            'total' => $total,
        ];
    }
}
