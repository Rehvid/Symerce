<?php

namespace App\DataFixtures\FakeData;

use App\Common\Domain\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $tags = [
            'Premium',
            'Najlepszy Sprzedawca',
            'Nowość',
            'Super Oferta',
            'Limitowana Edycja',
        ];

        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);

            $manager->persist($tag);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['fakeData'];
    }
}
