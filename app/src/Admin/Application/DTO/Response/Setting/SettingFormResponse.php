<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Setting;


use App\Setting\Application\Dto\SettingField;

final readonly class SettingFormResponse
{

    public function __construct(
        public SettingField $settingField,
        public bool $isActive,
        public string $name,
    ) {

    }
}
