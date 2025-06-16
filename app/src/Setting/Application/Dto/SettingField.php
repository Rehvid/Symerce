<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto;

use App\Setting\Domain\Enums\SettingInputType;
use App\Setting\Domain\Enums\SettingValueType;

final readonly class SettingField
{
    public function __construct(
        public SettingValueType $type,
        public SettingInputType $inputType,
        public mixed $value,
        public array $availableOptions = [],
    ) {
    }
}
