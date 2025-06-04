<?php

declare(strict_types=1);

namespace App\Setting\Domain\Repository;

use App\Common\Domain\Entity\Setting;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;

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
