<?php

namespace App\Factory;

use App\Service\SettingManager;
use App\Shared\Domain\ValueObject\Money;

final class MoneyFactory
{
    public function __construct(private readonly SettingManager $settingManager) {

    }

    public function create(string $amount): Money
    {
        return new Money($amount, $this->settingManager->findDefaultCurrency());
    }
}
