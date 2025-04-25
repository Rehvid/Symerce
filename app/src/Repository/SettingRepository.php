<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Setting;
use App\Repository\Base\PaginationRepository;

class SettingRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Setting::class;
    }

    protected function getAlias(): string
    {
        return 'global_settings';
    }

    public function findAllExcludingTypes(array $excludedTypes): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.type NOT IN (:excludedTypes)')
            ->setParameter('excludedTypes', $excludedTypes)
            ->getQuery()
            ->getResult();
    }
}
