<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Setting;

use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Entity\Setting;
use App\Service\DataPersister\Base\UpdatePersister;

final class SettingUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveSettingRequestDTO::class, Setting::class];
    }
}
