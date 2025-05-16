<?php

namespace App\Factory;

use App\Manager\OrderManager;
use App\Service\SettingManager;
use App\ValueObject\Money;

final class MoneyFactory
{
    public function __construct(private readonly SettingManager $settingManager) {

    }

    public function create(string $amount): Money
    {
        return new Money($amount, $this->settingManager->findDefaultCurrency());
    }
}
