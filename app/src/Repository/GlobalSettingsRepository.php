<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GlobalSettings;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class GlobalSettingsRepository extends PaginationRepository
{

    protected function getEntityClass(): string
    {
        return GlobalSettings::class;
    }

    protected function getAlias(): string
    {
        return 'global_settings';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        return $queryBuilder;
    }
}
