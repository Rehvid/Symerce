<?php

declare(strict_types=1);

namespace App\Common\Application\Factory;

use App\Common\Application\Service\SettingsService;
use App\Common\Domain\ValueObject\MoneyVO;

final readonly class MoneyFactory
{
    public function __construct(
        private  SettingsService $settingManager
    ) {
    }

    public function create(string $amount): MoneyVO
    {
        return new MoneyVO($amount, $this->settingManager->findDefaultCurrency());
    }
}
