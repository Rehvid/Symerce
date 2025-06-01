<?php

namespace App\DataFixtures\FakeData;

use App\Admin\Domain\Entity\Attribute;
use App\Admin\Domain\Entity\AttributeValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AttributeFixture  extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['fakeData'];
    }

    public function load(ObjectManager $manager): void
    {
        $data = $this->getData();

        foreach ($data as $k => $attribute) {
            $attributeEntity = new Attribute();
            $attributeEntity->setName($attribute['attribute']);
            $attributeEntity->setPosition($k);

            $manager->persist($attributeEntity);

            foreach ($attribute['values'] as $key => $option) {
                $attributeValue = new AttributeValue();
                $attributeValue->setAttribute($attributeEntity);
                $attributeValue->setValue($option);
                $attributeValue->setPosition($key);
                $manager->persist($attributeValue);
            }

        }

        $manager->flush();
    }

    public function getData(): array
    {
        return [
            [
                'attribute' => 'Szerokość',
                'values' => ['do 15cm', 'od 15cm do 30cm', 'od 30cm do 50cm', 'powyżej 50cm']
            ],
             [
                'attribute' => 'Wysokość',
                'values' => ['do 10cm', 'od 10cm do 20cm', 'od 20cm do 40cm', 'powyżej 40cm']
            ],
             [
                'attribute' => 'Głębokość',
                'values' => ['do 10cm', 'od 10cm do 20cm', 'od 20cm do 40cm', 'powyżej 40cm']
            ],
             [
                'attribute' => 'Waga',
                'values' => ['do 1kg', 'od 1kg do 3kg', 'od 3kg do 5kg', 'powyżej 5kg']
            ],
             [
                'attribute' => 'Rozmiar',
                'values' => ['mały', 'średni', 'duży', 'bardzo duży']
            ]
        ];
    }
}
