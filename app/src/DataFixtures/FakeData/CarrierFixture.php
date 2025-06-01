<?php

namespace App\DataFixtures\FakeData;

use App\Common\Domain\Entity\Carrier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CarrierFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $carriers = $this->getData();

        foreach ($carriers as $data) {
            $carrier = new Carrier();
            $carrier->setName($data['name']);
            $carrier->setFee($data['fee']);

            $manager->persist($carrier);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'name' => 'DHL',
                'fee' => '10.99',
            ],
            [
                'name' => 'Pocztex',
                'fee' => '12.50',
            ],
            [
                'name' => 'UPS',
                'fee' => '8.75',
            ]
        ];
    }

    public static function getGroups(): array
    {
        return ['fakeData'];
    }
}
