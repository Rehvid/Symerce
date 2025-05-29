<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\DataProvider;

use App\Admin\Application\Contract\ReactDataProviderInterface;
use App\Admin\Application\DTO\Response\ProviderResponse;
use App\Admin\Domain\Entity\Setting;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Setting\Infrastructure\Repository\SettingDoctrineRepository;
use App\Shared\Application\Service\SettingsService;

readonly class SettingsProvider implements ReactDataProviderInterface
{
    public function __construct(
        private SettingDoctrineRepository $settingRepository,
        private SettingsService           $settingManager,
    ) {
    }

    /** @return array<int, mixed> */
    public function getData(): array
    {
        $currency = $this->settingManager->findDefaultCurrency();
        $defaultCurrency = new ProviderResponse(
            settingKey:  SettingKey::CURRENCY,
            value: [
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'symbol' => $currency->getSymbol(),
                'code' => $currency->getCode(),
                'roundingPrecision' => $currency->getRoundingPrecision(),
            ],
        );

        $settings = $this->settingRepository->findAllExcludingKeys([
            SettingType::PRODUCT->value,
        ]);
        $result = array_map(function (Setting $setting) {
            return new ProviderResponse(
                settingKey: $setting->getKey(),
                value: [
                    'id' => $setting->getId(),
                    'name' => $setting->getName(),
                    'value' => $setting->getValue(),
                ],
            );
        }, $settings);

        return [
            $defaultCurrency,
            ...$result,
        ];
    }

    public function getName(): string
    {
        return 'settings';
    }
}
