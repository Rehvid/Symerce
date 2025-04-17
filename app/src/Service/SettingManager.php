<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;

final class SettingManager
{
    private SettingRepository $settingRepository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        /** @var SettingRepository $settingRepository */
        $settingRepository =  $this->entityManager->getRepository(Setting::class);
        $this->settingRepository = $settingRepository;
    }

    public function findDefaultCurrency(): Currency
    {
        /** @var Setting|null $setting */
        $setting = $this->settingRepository->findOneBy(['type' => SettingType::CURRENCY]);

        if (null === $setting) {
            throw new \LogicException('Default Currency not found');
        }

        $value = json_decode($setting->getValue(), true);

        if (empty($value)) {
            throw new \LogicException('Default Currency not found');
        }

        $currency = $this->entityManager->getRepository(Currency::class)->find($value['id']);

        if (null === $currency) {
            throw new \LogicException('Default Currency not found');
        }

        return $currency;
    }
}
