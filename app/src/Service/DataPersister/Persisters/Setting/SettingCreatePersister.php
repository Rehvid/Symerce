<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Setting;

use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class SettingCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveSettingRequestDTO::class];
    }
}
