<?php

declare(strict_types=1);

namespace App\Setting\Infrastructure\Repository;

use App\Common\Domain\Entity\Setting;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Setting\Domain\Repository\SettingRepositoryInterface;

/**
 * @extends AbstractCriteriaRepository<Setting>
 */
class SettingDoctrineRepository extends AbstractCriteriaRepository implements SettingRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Setting::class;
    }

    protected function getAlias(): string
    {
        return 's';
    }

    /**
     * @param array<int, mixed> $excludedKeys
     *
     * @return Setting[]
     */
    public function findAllExcludingKeys(array $excludedKeys): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->where("$alias.key NOT IN (:excludedKeys)")
            ->setParameter('excludedKeys', $excludedKeys)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Setting[]
     */
    public function findAllMetaSettings(): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->andWhere("$alias.isActive = :active")
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    public function findByType(SettingType $type): array
    {
        return $this->findBy(['type' => $type, 'isActive' => true]);
    }

    public function findByKey(SettingKey $type): ?Setting
    {
        return $this->findOneBy(['key' => $type, 'isActive' => true]);
    }
}
