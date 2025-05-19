<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Setting;


readonly class SettingCreateFormResponse
{
    /** @param array<int, mixed>  $availableTypes */
    public function __construct(
        public array $availableTypes,
        public ?SettingValueResponse $settingValue,
    ) {

    }
}
