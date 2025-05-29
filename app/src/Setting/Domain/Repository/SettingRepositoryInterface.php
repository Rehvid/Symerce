<?php

declare(strict_types=1);

namespace App\Setting\Domain\Repository;

use App\Admin\Domain\Entity\Setting;
use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface SettingRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    /**
     * @param array<int, mixed> $excludedKeys
     *
     * @return Setting[]
     */
    public function findAllExcludingKeys(array $excludedKeys): array;


    public function findByKey(SettingKey $type): ?Setting;
    public function findByType(SettingType $type): ?Setting;
}
