<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

enum CookieName: string
{
    case ADMIN_BEARER = 'BEARER';
    case SHOP_CART = 'cart';
}
