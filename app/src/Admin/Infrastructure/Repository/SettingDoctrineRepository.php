<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Setting;
use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Domain\Enums\SettingType;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

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
     * @param array<int, mixed> $excludedTypes
     *
     * @return Setting[]
     */
    public function findAllExcludingTypes(array $excludedTypes): array
    {
        $alias = $this->getAlias();

        return $this->createQueryBuilder($alias)
            ->where("$alias.type NOT IN (:excludedTypes)")
            ->setParameter('excludedTypes', $excludedTypes)
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
            ->where("$alias.type IN (:types)")
            ->andWhere("$alias.isActive = :active")
            ->setParameter('types', SettingType::getMetaTypes())
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    public function findByType(SettingType $type): ?Setting
    {
        return $this->findOneBy(['type' => $type]);
    }
}
