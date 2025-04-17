<?php

declare(strict_types=1);

namespace App\DataFixtures\Bootstrap;

use App\DataFixtures\Data\CurrencyData;
use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $currencies = CurrencyData::getData();
        foreach ($currencies as $data) {
            $currency = new Currency();
            $currency->setCode($data['code']);
            $currency->setSymbol($data['symbol']);
            $currency->setName($data['name']);
            $currency->setRoundingPrecision($data['roundingPrecision']);
            $currency->setIsProtected($data['isProtected']);
            $manager->persist($currency);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['bootstrap'];
    }
}
