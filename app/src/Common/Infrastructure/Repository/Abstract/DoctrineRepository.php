<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Repository\Abstract;

use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 *
 * @implements QueryRepositoryInterface<T>
 */
abstract class DoctrineRepository extends ServiceEntityRepository implements ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    /**
     * @return class-string<T>
     */
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
        $this->getEntityManager()->flush();
    }

    public function removeCollection(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->getEntityManager()->remove($entity);
        }

        $this->getEntityManager()->flush();
    }

    public function findById(int|string|null $id): ?object
    {
        return $this->find($id);
    }

    public function getCount(): int
    {
        return $this->count();
    }
}
