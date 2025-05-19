<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Entity\Setting;

interface SettingRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface
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
