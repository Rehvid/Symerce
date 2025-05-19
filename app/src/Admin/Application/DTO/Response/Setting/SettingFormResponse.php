<?php

namespace App\Admin\Application\DTO\Response\Setting;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class SettingFormResponse extends SettingCreateFormResponse
{
    /** @param array<int, mixed>  $types */
    public function __construct(
        public string                $name,
        public string                $type,
        public string                $value,
        public bool                  $isProtected,
        array                        $availableTypes,
        ?SettingValueResponse $settingValue,
    ) {
        parent::__construct($availableTypes, $settingValue);
    }
}
