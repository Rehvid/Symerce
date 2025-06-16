<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto;

use App\Setting\Domain\ValueObject\SettingValueVO;

final readonly class SettingData
{
    public function __construct(
        public string $name,
        public SettingValueVO $settingValueVO,
        public bool $isActive
    ) {
    }
}
