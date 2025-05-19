<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Admin\Domain\Enums\OrderByField;
use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\Pagination\PaginationFilters;
use App\Service\Pagination\PaginationMeta;
use App\Shared\Domain\Enums\DirectionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/** @phpstan-ignore-next-line */
abstract class AbstractRepository
    extends ServiceEntityRepository
    implements PaginationRepositoryInterface, OrderSortableRepositoryInterface, ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    private const int ALL_RESULTS = -1;

    abstract protected function getEntityClass(): string;

    abstract protected function getAlias(): string;

    /** @SuppressWarnings("UnusedFormalParameter") */
    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        return $queryBuilder;
    }

    public function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
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

            $baseQueryBuilder->orderBy("$alias.".$orderBy->value, $direction->value);
        }

        $this->configureQueryForPagination($baseQueryBuilder, $paginationFilters);

        $countQueryBuilder = clone $baseQueryBuilder;
        $countQueryBuilder->select("COUNT($alias.id)");

        $total = (int) $countQueryBuilder->getQuery()->getSingleScalarResult();

        if (self::ALL_RESULTS !== $paginationMeta->getLimit()) {
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

    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array
    {
        $alias = $this->getAlias();
        $queryBuilder = $this->createQueryBuilder($alias);

        if ($oldOrder < $newOrder) {
            return $queryBuilder->where("$alias.order > :oldOrder")
                ->andWhere("$alias.order <= :newOrder")
                ->setParameter('oldOrder', $oldOrder)
                ->setParameter('newOrder', $newOrder)
                ->orderBy("$alias.order", 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        return $queryBuilder->where("$alias.order >= :newOrder")
            ->andWhere("$alias.order < :oldOrder")
            ->setParameter('newOrder', $newOrder)
            ->setParameter('oldOrder', $oldOrder)
            ->orderBy("$alias.order", 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findById(int|string $id): ?object
    {
        return $this->find($id);
    }
}
