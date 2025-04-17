<?php

declare(strict_types=1);

namespace App\DataFixtures\Bootstrap;

use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SettingFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['bootstrap'];
    }

    public function load(ObjectManager $manager): void
    {
        $currency = $manager->getRepository(Currency::class)->findOneBy(['code' => 'PLN']);

        $value = [
            'id' => $currency?->getId(),
            'roundingPrecision' => $currency?->getRoundingPrecision() ?? 2,
        ];

        $setting = new Setting();
        $setting->setType(SettingType::CURRENCY);
        $setting->setValue((string) json_encode($value));
        $setting->setName('Domyślna waluta');
        $setting->setIsProtected(true);
        $setting->setActive(true);

        $manager->persist($setting);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CurrencyFixture::class,
        ];
    }
}
