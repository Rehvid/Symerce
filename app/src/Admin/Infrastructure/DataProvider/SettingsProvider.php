<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\DataProvider;

use App\Admin\Application\Contract\ReactDataProviderInterface;
use App\Admin\Application\DTO\Response\ProviderResponse;
use App\Admin\Infrastructure\Repository\SettingDoctrineRepository;
use App\Entity\Setting;
use App\Shared\Application\Service\SettingsService;
use App\Shared\Domain\Enums\SettingType;

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
