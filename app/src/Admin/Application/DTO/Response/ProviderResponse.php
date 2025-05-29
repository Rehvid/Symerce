<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response;

use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;

class ProviderResponse
{
    /** @param array<int,mixed>|string $value  */
    public function __construct(
        public SettingKey $settingKey,
        public array|string $value
    ) {

    }
}
