<?php

declare(strict_types=1);

namespace App\DataFixtures\Bootstrap;

use App\Admin\Domain\Entity\Currency;
use App\Admin\Domain\Entity\Setting;
use App\Shared\Domain\Enums\SettingType;
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
        $this->loadCurrencySetting($manager);
        $this->loadMetaShopTitleSetting($manager);
        $this->loadMetaShopDescriptionSetting($manager);
        $this->loadMetaShopOgTitleSetting($manager);
        $this->loadMetaShopOgDescriptionSetting($manager);
        $this->loadShopCategoriesSetting($manager);
        $this->loadProductRefundSetting($manager);
    }

    public function getDependencies(): array
    {
        return [
            CurrencyFixture::class,
        ];
    }

    private function loadCurrencySetting(ObjectManager $manager): void
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
        $setting->setIsJson(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadMetaShopTitleSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::META_SHOP_TITLE);
        $setting->setValue('Symerce - Sklep');
        $setting->setName('Tytuł SEO sklepu');
        $setting->setIsProtected(true);
        $setting->setActive(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadMetaShopDescriptionSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::META_SHOP_DESCRIPTION);
        $setting->setValue('Symerce to sklep internetowy, w którym znajdziesz starannie wyselekcjonowane produkty i wygodne zakupy online');
        $setting->setName('Opis SEO sklepu');
        $setting->setIsProtected(true);
        $setting->setActive(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadMetaShopOgTitleSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::META_SHOP_OG_TITLE);
        $setting->setValue('Sklep Internetowy dla Ciebie');
        $setting->setName('Tytuł ogólny (og:title) sklepu');
        $setting->setIsProtected(true);
        $setting->setActive(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadMetaShopOgDescriptionSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::META_SHOP_OG_DESCRIPTION);
        $setting->setValue('Zakupy online jeszcze nigdy nie były tak wygodne. Sprawdź bogatą ofertę produktów w sklepie Symerce.');
        $setting->setName('Opis ogólny (og:description) sklepu');
        $setting->setIsProtected(true);
        $setting->setActive(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadShopCategoriesSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::SHOP_CATEGORIES);
        $setting->setValue('[]');
        $setting->setName('Kategorie wyświetlane w sklepie (maks. 8)');
        $setting->setIsProtected(true);
        $setting->setActive(true);
        $setting->setIsJson(true);

        $manager->persist($setting);
        $manager->flush();
    }

    private function loadProductRefundSetting(ObjectManager $manager): void
    {
        $setting = new Setting();
        $setting->setType(SettingType::PRODUCT_REFUND);
        $setting->setName('Produkt dni do zwortu');
        $setting->setValue("14");
        $setting->setActive(true);
        $setting->setIsJson(false);
        $setting->setIsProtected(true);

        $manager->persist($setting);
        $manager->flush();
    }
}
