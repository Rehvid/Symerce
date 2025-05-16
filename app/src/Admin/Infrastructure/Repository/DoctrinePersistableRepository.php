<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\PersistableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class DoctrinePersistableRepository extends ServiceEntityRepository implements PersistableRepositoryInterface
{

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
