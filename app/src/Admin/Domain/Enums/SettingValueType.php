<?php

declare(strict_types=1);

namespace App\Admin\Domain\Enums;

enum SettingValueType: string
{
    case PLAIN_TEXT = 'plain_text';
    case SELECT = 'select';
    case MULTI_SELECT = 'multi_select';
}
