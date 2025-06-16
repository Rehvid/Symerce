<?php

declare(strict_types=1);

namespace App\Setting\Domain\Enums;

enum SettingKey: string
{
    case CURRENCY = 'currency';
    case SHOP_TITLE         = 'shop_title';
    case SHOP_DESCRIPTION   = 'shop_description';
    case SHOP_OG_TITLE      = 'shop_og_title';
    case SHOP_OG_DESCRIPTION = 'shop_og_description';
    case PRODUCT_REFUND_POLICY        = 'product_refund_policy';
    case ENABLE_PRICE_HISTORY         = 'enable_price_history';
    case SHOW_INFORMATION_PRODUCT_LOW_STOCK = 'show_information_product_low_stock';
    case SHOP_CATEGORIES              = 'shop_categories';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
