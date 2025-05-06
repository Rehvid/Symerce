<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Setting;

use App\DTO\Admin\Request\Setting\SaveSettingRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class SettingCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveSettingRequestDTO::class];
    }
}
