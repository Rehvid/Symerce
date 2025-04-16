<?php

namespace App\Service\DataPersister\Persisters\Setting;

use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Entity\GlobalSettings;
use App\Enums\SettingType;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use Hoa\Iterator\Glob;

class SettingCreatePersister extends CreatePersister
{


    /**
     * @param SaveSettingRequestDTO $persistable
     * @return GlobalSettings
     */
    protected function createEntity(PersistableInterface $persistable): object
    {
        $setting = new GlobalSettings();
        $setting->setValue($persistable->value);
        $setting->setType(SettingType::from($persistable->type));
        $setting->setIsProtected(false);
        $setting->setName($persistable->name);

        return $setting;
    }

    public function getSupportedClasses(): array
    {
        return [SaveSettingRequestDTO::class];
    }
}
