<?php

namespace App\Carrier\Infrastructure\Repository;

use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Domain\Entity\Carrier;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;

/**
 * @extends AbstractCriteriaRepository<Carrier>
 */
class CarrierDoctrineRepository extends AbstractCriteriaRepository implements CarrierRepositoryInterface
{
    /** @return array<int, mixed> */
    public function findLowestAndHighestFee(): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->select("MAX($alias.fee) as maxFee, MIN($alias.fee) as minFee")
            ->andWhere("$alias.isActive = :active")
            ->setParameter('active', true)
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
