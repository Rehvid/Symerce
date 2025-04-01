<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Repository\Interface\BaseRepositoryInterface;
use App\Service\Pagination\PaginationMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseRepository extends ServiceEntityRepository implements BaseRepositoryInterface
{
    abstract protected function getEntityClass(): string;

    abstract protected function getAlias(): string;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    public function findPaginated(PaginationMeta $paginationMeta, array $queryParams = []): array
    {
        $search = $queryParams['search'] ?? null;

        $alias = $this->getAlias();
        $queryBuilder = $this->createQueryBuilder($alias)
            ->setFirstResult($paginationMeta->getOffset())
            ->setMaxResults($paginationMeta->getLimit())
            ->orderBy("$alias.order", 'ASC')
        ;

        if (null !== $search && '' !== trim($search)) {
            $queryBuilder
                ->andWhere("$alias.name LIKE :search")
                ->setParameter('search', "%$search%")
            ;
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
