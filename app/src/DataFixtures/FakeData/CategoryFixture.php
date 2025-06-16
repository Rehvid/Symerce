<?php

namespace App\DataFixtures\FakeData;

use App\Common\Domain\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['fakeData'];
    }

    public function load(ObjectManager $manager): void
    {
        $categoriesData = $this->getCategoriesData();

        foreach ($categoriesData as $categoryData) {
            // Tworzymy kategorię główną
            $category = new Category();
            $category->setName($categoryData['name']);
            $category->setSlug($categoryData['slug']);
            $category->setDescription($categoryData['description']);
            $category->setCreatedAt(new \DateTime($categoryData['createdAt']));
            $category->setUpdatedAt(new \DateTime($categoryData['updatedAt']));
            $category->setPosition($categoryData['order']);

            foreach ($categoryData['children'] as $childData) {

                $childCategory = new Category();
                $childCategory->setName($childData['name']);
                $childCategory->setSlug($childData['slug']);
                $childCategory->setDescription($childData['description']);
                $childCategory->setCreatedAt(new \DateTime($childData['createdAt']));
                $childCategory->setUpdatedAt(new \DateTime($childData['updatedAt']));
                $childCategory->setPosition($childData['order']);
                $childCategory->setParent($category);

                $category->addChildren($childCategory);

                $manager->persist($childCategory);
            }


            $manager->persist($category);
        }

        $manager->flush();
    }

    private function getCategoriesData(): array
    {
        return [
            [
                'name' => 'Elektronika',
                'slug' => 'elektronika',
                'description' => 'Kategoria z produktami elektronicznymi',
                'parent' => null,
                'createdAt' => '2025-05-01 08:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 1,
                'children' => [
                    ['name' => 'Smartfony', 'slug' => 'smartfony', 'description' => 'Telefony komórkowe i akcesoria', 'createdAt' => '2025-05-01 08:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Laptopy', 'slug' => 'laptopy', 'description' => 'Laptopy i komputery przenośne', 'createdAt' => '2025-05-01 08:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Telewizory', 'slug' => 'telewizory', 'description' => 'Telewizory LED, OLED, 4K i więcej', 'createdAt' => '2025-05-01 08:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Odzież',
                'slug' => 'odziez',
                'description' => 'Kategoria z odzieżą męską, damską i dziecięcą',
                'parent' => null,
                'createdAt' => '2025-05-02 09:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 2,
                'children' => [
                    ['name' => 'Odzież męska', 'slug' => 'odziez-meska', 'description' => 'Koszule, spodnie, kurtki i akcesoria dla mężczyzn', 'createdAt' => '2025-05-02 09:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Odzież damska', 'slug' => 'odziez-damska', 'description' => 'Sukienki, bluzki, spodnie i dodatki dla kobiet', 'createdAt' => '2025-05-02 09:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Odzież dziecięca', 'slug' => 'odziez-dziecieca', 'description' => 'Odzież dla dzieci w każdym wieku', 'createdAt' => '2025-05-02 09:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Dom i ogród',
                'slug' => 'dom-i-ogrod',
                'description' => 'Produkty do domu, ogrodu i wykończenia wnętrz',
                'parent' => null,
                'createdAt' => '2025-05-03 10:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 3,
                'children' => [
                    ['name' => 'Meble', 'slug' => 'meble', 'description' => 'Meble do salonu, sypialni, biura i ogrodu', 'createdAt' => '2025-05-03 10:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Oświetlenie', 'slug' => 'oswietlenie', 'description' => 'Lampy, żarówki, oświetlenie dekoracyjne', 'createdAt' => '2025-05-03 10:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Narzędzia', 'slug' => 'narzedzia', 'description' => 'Narzędzia do prac domowych i ogrodowych', 'createdAt' => '2025-05-03 10:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Zdrowie i uroda',
                'slug' => 'zdrowie-i-uroda',
                'description' => 'Produkty kosmetyczne, suplementy diety, zdrowie',
                'parent' => null,
                'createdAt' => '2025-05-04 11:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 4,
                'children' => [
                    ['name' => 'Kosmetyki', 'slug' => 'kosmetyki', 'description' => 'Kosmetyki do pielęgnacji skóry, włosów, twarzy', 'createdAt' => '2025-05-04 11:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Suplementy diety', 'slug' => 'suplementy-diety', 'description' => 'Suplementy na zdrowie, witalność i urodę', 'createdAt' => '2025-05-04 11:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Pielęgnacja ciała', 'slug' => 'pielegnacja-ciala', 'description' => 'Kremy, balsamy, olejki do pielęgnacji skóry', 'createdAt' => '2025-05-04 11:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Sport i rekreacja',
                'slug' => 'sport-i-rekreacja',
                'description' => 'Produkty sportowe i rekreacyjne',
                'parent' => null,
                'createdAt' => '2025-05-05 12:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 5,
                'children' => [
                    ['name' => 'Odzież sportowa', 'slug' => 'odziez-sportowa', 'description' => 'Odzież i akcesoria do ćwiczeń i aktywności fizycznej', 'createdAt' => '2025-05-05 12:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Sprzęt fitness', 'slug' => 'sprzet-fitness', 'description' => 'Sprzęt do ćwiczeń w domu i na siłowni', 'createdAt' => '2025-05-05 12:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Turystyka', 'slug' => 'turystyka', 'description' => 'Sprzęt i akcesoria turystyczne', 'createdAt' => '2025-05-05 12:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Kultura i rozrywka',
                'slug' => 'kultura-i-rozrywka',
                'description' => 'Produkty związane z kulturą, muzyką i zabawą',
                'parent' => null,
                'createdAt' => '2025-05-06 13:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 6,
                'children' => [
                    ['name' => 'Książki', 'slug' => 'ksiazki', 'description' => 'Literatura, książki edukacyjne, powieści', 'createdAt' => '2025-05-06 13:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Filmy i seriale', 'slug' => 'filmy-i-seriale', 'description' => 'Filmy DVD, Blu-Ray, subskrypcje cyfrowe', 'createdAt' => '2025-05-06 13:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Muzyka', 'slug' => 'muzyka', 'description' => 'Płyty CD, winyle, subskrypcje muzyczne', 'createdAt' => '2025-05-06 13:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Motoryzacja',
                'slug' => 'motoryzacja',
                'description' => 'Akcesoria i części samochodowe',
                'parent' => null,
                'createdAt' => '2025-05-07 14:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 7,
                'children' => [
                    ['name' => 'Części samochodowe', 'slug' => 'czesci-samochodowe', 'description' => 'Części i akcesoria samochodowe', 'createdAt' => '2025-05-07 14:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Opony i felgi', 'slug' => 'opony-i-felgi', 'description' => 'Opony, felgi i akcesoria do kół', 'createdAt' => '2025-05-07 14:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Akcesoria samochodowe', 'slug' => 'akcesoria-samochodowe', 'description' => 'Pokrowce, gadżety i akcesoria samochodowe', 'createdAt' => '2025-05-07 14:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
            [
                'name' => 'Artykuły biurowe',
                'slug' => 'artykuly-biurowe',
                'description' => 'Produkty dla biura i organizacji pracy',
                'parent' => null,
                'createdAt' => '2025-05-08 15:00:00',
                'updatedAt' => '2025-05-10 12:00:00',
                'order' => 8,
                'children' => [
                    ['name' => 'Papier', 'slug' => 'papier', 'description' => 'Papier do drukarek, notesy, karteczki', 'createdAt' => '2025-05-08 15:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 1],
                    ['name' => 'Narzędzia biurowe', 'slug' => 'narzedzia-biurowe', 'description' => 'Długopisy, zszywacze, tusze, kalkulatory', 'createdAt' => '2025-05-08 15:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 2],
                    ['name' => 'Meble biurowe', 'slug' => 'meble-biurowe', 'description' => 'Biurka, krzesła, regały i akcesoria', 'createdAt' => '2025-05-08 15:00:00', 'updatedAt' => '2025-05-10 12:00:00', 'order' => 3],
                ],
            ],
        ];

    }
}
