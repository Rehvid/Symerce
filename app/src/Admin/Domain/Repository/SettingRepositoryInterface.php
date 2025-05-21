<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Entity\Setting;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface SettingRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    /**
     * @param array<int, mixed> $excludedTypes
     *
     * @return Setting[]
     */
    public function findAllExcludingTypes(array $excludedTypes): array;

    /**
     * @return Setting[]
     */
    public function findAllMetaSettings(): array;
}
