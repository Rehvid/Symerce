<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\Pagination\PaginationFilters;
use App\Service\Pagination\PaginationMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/** @phpstan-ignore-next-line */
abstract class AbstractRepository extends ServiceEntityRepository implements PaginationRepositoryInterface
{
    private const int ALL_RESULTS = -1;

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

        if ($paginationFilters->hasOrderBy()) {
            /** @var OrderByField $orderBy */
            $orderBy = $paginationFilters->getOrderBy();
            /** @var DirectionType $direction */
            $direction = $paginationFilters->getDirection();

            $baseQueryBuilder->orderBy("$alias." . $orderBy->value, $direction->value);
        }

        $this->configureQueryForPagination($baseQueryBuilder, $paginationFilters);

        $countQueryBuilder = clone ($baseQueryBuilder);
        $countQueryBuilder->select("COUNT($alias.id)");

        $total = (int) $countQueryBuilder->getQuery()->getSingleScalarResult();

        if ($paginationMeta->getLimit() !== self::ALL_RESULTS) {
            $baseQueryBuilder
                ->setFirstResult($paginationMeta->getOffset())
                ->setMaxResults($paginationMeta->getLimit());
        }

        $items = $baseQueryBuilder->getQuery()->getResult();

        return [
            'items' => $items,
            'total' => $total,
        ];
    }

    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array
    {
        $qb = $this->createQueryBuilder($this->getAlias());

        if ($oldOrder < $newOrder) {
            $qb->where('e.order > :oldOrder')
                ->andWhere('e.order <= :newOrder')
                ->setParameter('oldOrder', $oldOrder)
                ->setParameter('newOrder', $newOrder)
                ->orderBy('e.order', 'ASC');
        } else {
            $qb->where('e.order >= :newOrder')
                ->andWhere('e.order < :oldOrder')
                ->setParameter('newOrder', $newOrder)
                ->setParameter('oldOrder', $oldOrder)
                ->orderBy('e.order', 'DESC');
        }

        return $qb->getQuery()->getResult();
    }
}
