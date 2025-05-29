<?php

declare(strict_types=1);

namespace App\Setting\Domain\Enums;

enum SettingInputType: string
{
    case TEXT = 'text';
    case SELECT = 'select';
    case MULTISELECT = 'multiselect';
    case CHECKBOX = 'checkbox';
    case RAW_TEXTAREA = 'raw_textarea';
    case NUMBER = 'number';
}
