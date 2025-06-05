<?php

declare(strict_types=1);

namespace App\Setting\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum SettingValueType: string
{
    use EnumValuesTrait;

    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case JSON = 'json';
    case INTEGER = 'integer';
    case FLOAT = 'float';
}
