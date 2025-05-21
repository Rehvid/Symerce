<?php

namespace App\DataFixtures\FakeData;

use App\Admin\Domain\Entity\Carrier;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Enums\DeliveryType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DeliveryTimeFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            CarrierFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $carriers = $manager->getRepository(Carrier::class)->findAll();

        $deliveryTimes = $this->getData();

        foreach ($deliveryTimes as $data) {
            $deliveryTime = new DeliveryTime();
            $deliveryTime->setLabel($data['label']);
            $deliveryTime->setMinDays($data['minDays']);
            $deliveryTime->setMaxDays($data['maxDays']);
            $deliveryTime->setType($data['type']);

//            $carriersCollection = $deliveryTime->getCarriers();
//            $carriersCollection->add($carriers[array_rand($carriers)]);
//            $carriersCollection->add($carriers[array_rand($carriers)]);

            $manager->persist($deliveryTime);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'label' => 'Standardowa dostawa',
                'minDays' => 3,
                'maxDays' => 5,
                'type' => DeliveryType::STANDARD,
            ],
            [
                'label' => 'Ekspresowa dostawa',
                'minDays' => 1,
                'maxDays' => 2,
                'type' => DeliveryType::EXPRESS,
            ],
            [
                'label' => 'Dostawa ekonomiczna',
                'minDays' => 5,
                'maxDays' => 7,
                'type' => DeliveryType::ECONOMY,
            ],
        ];
    }

    public static function getGroups(): array
    {
        return ['fakeData'];
    }

}
