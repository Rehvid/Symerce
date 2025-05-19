<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enums;

enum SettingType: string
{
    case CURRENCY = 'currency';
    case META_SHOP_TITLE = 'meta_shop_title';
    case META_SHOP_DESCRIPTION = 'meta_shop_description';
    case META_SHOP_OG_TITLE = 'meta_shop_og_title';
    case META_SHOP_OG_DESCRIPTION = 'meta_shop_og_description';
    case CUSTOM = 'custom';
    case SHOP_CATEGORIES = 'shop_categories';

    case PRODUCT_REFUND = 'product_refund';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    /**
     * @return array<string, mixed>
     */
    public static function translatedOptions(): array
    {
        return [
            'base.setting_type' => self::CUSTOM,
        ];
    }

    /**
     * @return array<int, self>
     */
    public static function getMetaTypes(): array
    {
        return [
            self::META_SHOP_TITLE,
            self::META_SHOP_DESCRIPTION,
            self::META_SHOP_OG_TITLE,
            self::META_SHOP_OG_DESCRIPTION,
        ];
    }
}
