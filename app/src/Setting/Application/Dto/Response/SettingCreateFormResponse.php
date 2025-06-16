<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto\Response;

readonly class SettingCreateFormResponse
{
    /** @param array<int, mixed>  $availableTypes */
    public function __construct(
        public array $availableTypes,
        public ?SettingValueResponse $settingValue,
    ) {

    }
}
