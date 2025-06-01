<?php

namespace App\DataFixtures\FakeData;

use App\Common\Domain\Entity\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class VendorFixture extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['fakeData'];
    }

    public function load(ObjectManager $manager): void
    {
        $vendorsData = [
            ['name' => 'ABC Artykuły'],
            ['name' => 'XYZ Technologie'],
            ['name' => 'Super Sklep'],
            ['name' => 'Globalne Towary'],
            ['name' => 'Szybki Zakup']
        ];

        foreach ($vendorsData as $data) {
            $vendor = new Vendor();
            $vendor->setName($data['name']);
            $vendor->setActive(true);
            $manager->persist($vendor);
        }

        $manager->flush();
    }
}
