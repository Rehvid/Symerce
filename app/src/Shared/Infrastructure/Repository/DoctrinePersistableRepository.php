<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Admin\Domain\Repository\PersistableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class DoctrinePersistableRepository extends ServiceEntityRepository implements PersistableRepositoryInterface
{
    abstract protected function getEntityClass(): string;

    abstract protected function getAlias(): string;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    public function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }
}
