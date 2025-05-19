<?php

declare(strict_types=1);

namespace App\Service\DataProvider;

use App\Admin\Application\DTO\Response\ProviderResponse;
use App\Admin\Infrastructure\Repository\SettingDoctrineRepository;
use App\Entity\Setting;
use App\Service\DataProvider\Interface\ReactDataInterface;
use App\Service\SettingManager;
use App\Shared\Domain\Enums\SettingType;

readonly class SettingsProvider implements ReactDataInterface
{
    public function __construct(
        private SettingDoctrineRepository $settingRepository,
        private SettingManager            $settingManager,
    ) {
    }

    /** @return array<int, mixed> */
    public function getData(): array
    {
        $currency = $this->settingManager->findDefaultCurrency();
        $defaultCurrency = ProviderResponse::fromArray([
            'type' => SettingType::CURRENCY,
            'value' => [
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'symbol' => $currency->getSymbol(),
                'code' => $currency->getCode(),
                'roundingPrecision' => $currency->getRoundingPrecision(),
            ],
        ]);

        $settings = $this->settingRepository->findAllExcludingTypes([
            SettingType::CURRENCY->value,
        ]);
        $result = array_map(function (Setting $setting) {
            return ProviderResponse::fromArray([
                'type' => $setting->getType(),
                'value' => [
                    'id' => $setting->getId(),
                    'name' => $setting->getName(),
                    'value' => $setting->getValue(),
                ],
            ]);
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
