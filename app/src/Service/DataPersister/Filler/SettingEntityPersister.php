<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<SaveSettingRequestDTO>
 */
final class SettingEntityPersister extends BaseEntityFiller
{
    public function toNewEntity(PersistableInterface|SaveSettingRequestDTO $persistable): Setting
    {
        $globalSettings = new Setting();
        $globalSettings->setType(SettingType::from($persistable->type));
        $globalSettings->setIsProtected(false);
        $globalSettings->setName($persistable->name);

        return $this->fillEntity($persistable, $globalSettings);
    }

    /**
     * @param Setting $entity
     */
    public function toExistingEntity(
        PersistableInterface|SaveSettingRequestDTO $persistable,
        object $entity
    ): Setting {
        $entity = $this->fillEntity($persistable, $entity);

        if ($persistable->isProtected) {
            return $entity;
        }
        $entity->setType(SettingType::from($persistable->type));
        $entity->setName($persistable->name);

        return $entity;
    }

    public static function supports(): string
    {
        return SaveSettingRequestDTO::class;
    }

    /**
     * @param Setting $entity
     */
    protected function fillEntity(
        PersistableInterface|SaveSettingRequestDTO $persistable,
        object $entity
    ): Setting {
        $entity->setValue($persistable->value);

        return $entity;
    }
}
