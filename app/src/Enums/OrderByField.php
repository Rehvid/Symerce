<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderByField: string
{
    case NAME = 'name';
    case IS_ACTIVE = 'isActive';
    case QUANTITY = 'quantity';
    case ID = 'id';
    case REGULAR_PRICE = 'regularPrice';
    case DISCOUNT_PRICE = 'discountPrice';
    case ORDER = 'order';
    case FEE = 'fee';
    case SLUG = 'slug';
    case SYMBOL = 'symbol';
    case CODE = 'code';
    case ROUNDING_PRECISION = 'roundingPrecision';
    case LABEL = 'label';
    case TYPE = 'type';
    case MIN_DAYS = 'minDays';
    case MAX_DAYS = 'maxDays';
    case EMAIL = 'email';
}
