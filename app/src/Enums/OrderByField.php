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
}
