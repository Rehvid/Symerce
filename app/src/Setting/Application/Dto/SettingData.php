<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto;

use App\Admin\Domain\Entity\Setting;

final readonly class SettingData
{
    public function __construct(
        public Setting $setting,
        public string $name,
        public string $settingValueType,
        public mixed $value,
        public bool $isActive
    ) {}
}
