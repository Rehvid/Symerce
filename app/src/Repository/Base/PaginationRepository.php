<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Repository\Interface\PaginationRepositoryInterface;
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
    abstract protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder;

    public function __construct(ManagerRegistry $registry)
    {
        /* @phpstan-ignore-next-line */
        parent::__construct($registry, $this->getEntityClass());
    }

    public function findPaginated(PaginationMeta $paginationMeta, array $queryParams = []): array
    {
        $search = $queryParams['search'] ?? null;

        $alias = $this->getAlias();
        $queryBuilder = $this->createQueryBuilder($alias)
            ->setFirstResult($paginationMeta->getOffset())
            ->setMaxResults($paginationMeta->getLimit())
        ;

        if (null !== $search && '' !== trim($search)) {
            $queryBuilder
                ->andWhere("$alias.name LIKE :search")
                ->setParameter('search', "%$search%")
            ;
        }

        $queryBuilder = $this->configureQueryForPagination($queryBuilder, $queryParams);

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
