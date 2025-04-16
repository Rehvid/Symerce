<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vendor;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class VendorRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
        return Vendor::class;
    }

    protected function getAlias(): string
    {
        return 'vendor';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder
            ->select("$alias.id, $alias.name, image.path")
            ->leftJoin("$alias.image", 'image')
            ;
    }
}
