<?php

declare(strict_types=1);

namespace App\AdminEntry\Application\Dto\Response;

use App\Setting\Domain\Enums\SettingKey;

class ProviderResponse
{
    /** @param array<int,mixed>|string $value  */
    public function __construct(
        public SettingKey $settingKey,
        public array|string $value
    ) {

    }
}
