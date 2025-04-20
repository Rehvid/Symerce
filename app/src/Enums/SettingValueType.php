<?php

declare(strict_types=1);

namespace App\Enums;

enum SettingValueType: string
{
    case PLAIN_TEXT = 'plain_text';
    case SELECT = 'select';
}
