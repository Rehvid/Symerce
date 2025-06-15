<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum PromotionSource: string
{
    use EnumValuesTrait;

    case PRODUCT_TAB   = 'product_tab';

}
