<?php

declare(strict_types=1);

namespace App\Setting\Application\Dto\Response;

use App\Setting\Domain\Enums\SettingValueType;

readonly class SettingValueResponse
{
    public function __construct(
        public SettingValueType $type,
        public mixed $value = null,
    ) {
    }
}
