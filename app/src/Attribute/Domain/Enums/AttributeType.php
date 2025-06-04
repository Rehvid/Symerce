<?php

declare(strict_types=1);

namespace App\Attribute\Domain\Enums;

enum AttributeType: string
{
    case RAW_TEXTAREA = 'raw_textarea';
    case TEXTAREA = 'textarea';
    case TEXT = 'text';
    case NUMBER = 'number';
    case COLOR = 'color';
}
