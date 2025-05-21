<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enums;

enum QueryOperator: string
{
    case EQ       = 'eq';
    case IN       = 'in';
    case BETWEEN  = 'between';
    case LIKE     = 'like';
    case IS_NULL  = 'is_null';
    case GT       = 'gt';
    case LT       = 'lt';
}
