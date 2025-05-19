<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Enums\SettingValueType;

readonly class SettingValueResponse
{
    public function __construct(
        public SettingValueType $type,
        public mixed $value = null,
    ) {
    }
}
