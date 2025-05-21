<?php

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Entity\Carrier;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CarrierDoctrineRepository extends AbstractCriteriaRepository implements CarrierRepositoryInterface
{

    /** @return array<int, mixed> */
    public function findLowestAndHighestFee(): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->select("MAX($alias.fee) as maxFee, MIN($alias.fee) as minFee")
            ->andWhere("$alias.isActive = :active")
            ->setParameter("active", true)
            ->getQuery()
            ->getSingleResult();
    }

    protected function getEntityClass(): string
    {
        return Carrier::class;
    }

    protected function getAlias(): string
    {
        return 'carrier';
    }
}
