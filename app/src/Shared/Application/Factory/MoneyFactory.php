<?php

declare(strict_types=1);

namespace App\Shared\Application\Factory;

use App\Service\SettingManager;
use App\Shared\Domain\ValueObject\Money;

final readonly class MoneyFactory
{
    public function __construct(
        private  SettingManager $settingManager
    ) {
    }

    public function create(string $amount): Money
    {
        return new Money($amount, $this->settingManager->findDefaultCurrency());
    }
}
