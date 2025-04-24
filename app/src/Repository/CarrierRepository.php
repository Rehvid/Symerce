<?php

namespace App\Repository;

use App\Entity\Carrier;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class CarrierRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Carrier::class;
    }

    protected function getAlias(): string
    {
        return 'carrier';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = [], array $additionalData = []): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder
            ->select("$alias.id, $alias.name, $alias.isActive, $alias.fee, image.path")
            ->leftJoin("$alias.image", 'image')
        ;
    }
}
