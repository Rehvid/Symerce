<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Setting;

use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Entity\GlobalSettings;
use App\Enums\SettingType;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class SettingUpdatePersister extends UpdatePersister
{

    /**
     * @param SaveSettingRequestDTO $persistable
     * @param GlobalSettings $entity
     * @return GlobalSettings
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setValue($persistable->value);
        if ($persistable->isProtected) {
            return $entity;
        }
        $entity->setType(SettingType::from($persistable->type));
        $entity->setName($persistable->name);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveSettingRequestDTO::class, GlobalSettings::class];
    }
}
