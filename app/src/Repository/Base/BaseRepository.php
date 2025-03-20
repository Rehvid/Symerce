<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Repository\Interface\BaseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseRepository extends ServiceEntityRepository implements BaseRepositoryInterface
{
    abstract protected function getEntityClass() : string;
    abstract protected function getAlias() : string;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    public function findPaginated(array $queryParams)
    {
        $perPage = $queryParams['perPage'] ?? 10;
        $page = $queryParams['page'] ?? 1;
        $search = $queryParams['search'] ?? null;

        $firstResult = ($page - 1) * $perPage;
        $alias = $this->getAlias();

        $queryBuilder = $this->createQueryBuilder($alias)
            ->setFirstResult($firstResult)
            ->setMaxResults((int) $perPage)
            ->orderBy("$alias.order", 'ASC')
        ;

        if ($search !== null) {
            $queryBuilder
                ->andWhere("$alias.name LIKE :search")
                ->setParameter('search', "%$search%")
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
