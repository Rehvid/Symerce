<?php

declare(strict_types=1);

namespace App\Attribute\Domain\Enums;

enum AttributeType: string
{
    case SELECT = 'select';
    case TEXT = 'text';
    case NUMBER = 'number';
    case BOOLEAN = 'boolean';
    case COLOR = 'color';
}
