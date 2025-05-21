<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Response;

final readonly class SettingShopCategoryResponse
{
    public function __construct(
        public string $name,
        public string $url
    ) {
    }
}
