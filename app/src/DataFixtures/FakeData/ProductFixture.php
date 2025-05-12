<?php

namespace App\DataFixtures\FakeData;

use App\Entity\Attribute;
use App\Entity\Category;
use App\Entity\DeliveryTime;
use App\Entity\Product;
use App\Entity\Tag;
use App\Entity\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['fakeData'];
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            TagFixture::class,
            CarrierFixture::class,
            DeliveryTimeFixture::class,
            VendorFixture::class,
            AttributeFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $dataList = $this->getData();

        $categories = $manager->getRepository(Category::class)->findAll();
        $deliveryTimes = $manager->getRepository(DeliveryTime::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        /** @var Vendor[]|Collection $vendors */
        $vendors = $manager->getRepository(Vendor::class)->findAll();

        /** @var Attribute[]|Collection $attributes */
        $attributes = $manager->getRepository(Attribute::class)->findAll();

        foreach ($dataList as $i => $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setSlug($data['slug']);
            $product->setRegularPrice($data['regularPrice']);
            $product->setDiscountPrice($data['discountPrice']);
            $product->setQuantity($data['quantity']);
            $product->setActive($data['isActive']);
            $product->setOrder($data['order']);
            $product->setCreatedAt($data['created_at'] ?? new \DateTime());
            $product->setUpdatedAt($data['updated_at'] ?? new \DateTime());

            if (count($vendors) > 0) {
                $randomVendor = $vendors[array_rand($vendors)];
                $product->setVendor($randomVendor);
            }

            foreach ($attributes as $attribute) {
                foreach ($attribute->getValues() as $value) {
                    $product->addAttributeValue($value);
                }
            }

            $categorySlug = $data['categorySlug'];
            $category = null;
            foreach ($categories as $cat) {
                if ($cat->getSlug() === $categorySlug) {
                    $category = $cat;
                    break;
                }
            }

            if ($category !== null) {
                $product->addCategory($category);
            }

            $deliveryTimeSlug = $data['deliveryTimeSlug'];
            $deliveryTime = null;
            foreach ($deliveryTimes as $deliveryTimeEntity) {
                if ($deliveryTimeEntity->getType()->value === $deliveryTimeSlug) {
                    $deliveryTime = $deliveryTimeEntity;
                    break;
                }
            }

            if ($deliveryTime !== null) {
                $product->setDeliveryTime($deliveryTime);
            }

            foreach ($data['tagSlugs'] as $tagSlug) {
                $tag = null;
                foreach ($tags as $t) {
                    if ($t->getName() === $tagSlug) {
                        $tag = $t;
                        break;
                    }
                }

                if ($tag !== null) {
                    $product->addTag($tag);
                }
            }

            $manager->persist($product);
            $this->addReference('product_' . $i, $product);
        }

        $manager->flush();
    }
    private function getData(): array
    {
        return [
            [
                'name' => 'Elegancki zegarek',
                'description' => 'Klasyczny zegarek na skórzanym pasku',
                'slug' => 'elegancki-zegarek', 'regularPrice' => '499.99',
                'discountPrice' => '459.99',
                'quantity' => 15,
                'isActive' => true,
                'order' => 0,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'elektronika',
                'tagSlugs' => ['Premium', 'Nowość'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Słuchawki bezprzewodowe',
                'description' => 'Nowoczesne słuchawki Bluetooth',
                'slug' => 'sluchawki-bezprzewodowe',
                'regularPrice' => '299.00',
                'discountPrice' => null,
                'quantity' => 30,
                'isActive' => true,
                'order' => 1,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'smartfony',
                'tagSlugs' => ['Super Oferta'],
                'deliveryTimeSlug' => 'express'],
            [
                'name' => 'Laptop gamingowy',
                'description' => 'Wydajny laptop z RTX 3070',
                'slug' => 'laptop-gamingowy',
                'regularPrice' => '5599.00',
                'discountPrice' => '5299.00',
                'quantity' => 5,
                'isActive' => true,
                'order' => 2,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'laptopy', 
                'tagSlugs' => ['Limitowana Edycja'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Smartfon OLED',
                'description' => 'Telefon z ekranem OLED 6.5"',
                'slug' => 'smartfon-oled',
                'regularPrice' => '2499.99',
                'discountPrice' => null,
                'quantity' => 20,
                'isActive' => true, 'order' => 3,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'smartfony',
                'tagSlugs' => ['najlepszy_sprzedawca'],
                'deliveryTimeSlug' => 'standard',
            ],
            [
                'name' => 'Rower górski',
                'description' => 'Aluminiowa rama, amortyzacja przednia',
                'slug' => 'rower-gorski',
                'regularPrice' => '1799.50',
                'discountPrice' => '1649.50',
                'quantity' => 8,
                'isActive' => true,
                'order' => 4,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'narzedzia',
                'tagSlugs' => ['Premium'],
                'deliveryTimeSlug' => 'economy',
            ],
            [
                'name' => 'Torba na laptopa',
                'description' => 'Wodoodporna torba do 15,6"',
                'slug' => 'torba-na-laptopa',
                'regularPrice' => '129.99',
                'discountPrice' => null,
                'quantity' => 40,
                'isActive' => true,
                'order' => 5,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'laptopy',
                'tagSlugs' => ['Nowość'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Aparat fotograficzny',
                'description' => 'Lustrzanka cyfrowa z obiektywem 18-55mm',
                'slug' => 'aparat-fotograficzny',
                'regularPrice' => '3199.00',
                'discountPrice' => '2999.00',
                'quantity' => 12,
                'isActive' => true,
                'order' => 6,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'telewizory',
                'tagSlugs' => ['Super Oferta', 'Limitowana Edycja'],
                'deliveryTimeSlug' => 'express'
            ],
            [
                'name' => 'Książka kucharska',
                'description' => 'Przepisy na dania kuchni świata',
                'slug' => 'ksiazka-kucharska',
                'regularPrice' => '59.90',
                'discountPrice' => null,
                'quantity' => 100,
                'isActive' => true,
                'order' => 7,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'ksiazki',
                'tagSlugs' => ['Nowość'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Stolik nocny',
                'description' => 'Drewniany stolik z szufladą',
                'slug' => 'stolik-nocny',
                'regularPrice' => '349.00',
                'discountPrice' => '299.00',
                'quantity' => 22,
                'isActive' => true,
                'order' => 8,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'meble',
                'tagSlugs' => ['Premium'],
                'deliveryTimeSlug' => 'economy'
            ],
            [
                'name' => 'Zestaw garnków',
                'description' => 'Stal nierdzewna, 5 częściowy',
                'slug' => 'zestaw-garnkow',
                'regularPrice' => '599.00',
                'discountPrice' => '549.00',
                'quantity' => 18,
                'isActive' => true,
                'order' => 9,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'meble',
                'tagSlugs' => ['Limitowana Edycja'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Monitor 4K 27"',
                'description' => 'IPS 3840x2160 HDR10',
                'slug' => 'monitor-4k-27',
                'regularPrice' => '1799.00',
                'discountPrice' => '1699.00',
                'quantity' => 25,
                'isActive' => true,
                'order' => 10,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'telewizory',
                'tagSlugs' => ['Super Oferta'],
                'deliveryTimeSlug' => 'express',
            ],
            [
                'name' => 'Klawiatura mechaniczna',
                'description' => 'Cherry MX Red RGB',
                'slug' => 'klawiatura-mechaniczna',
                'regularPrice' => '349.99',
                'discountPrice' => null,
                'quantity' => 45,
                'isActive' => true,
                'order' => 11,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'narzedzia',
                'tagSlugs' => ['Nowość'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Mysz gamingowa',
                'description' => 'Ergonomiczna, 16000 DPI',
                'slug' => 'mysz-gamingowa',
                'regularPrice' => '199.00',
                'discountPrice' => '179.00',
                'quantity' => 60,
                'isActive' => true,
                'order' => 12,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'narzedzia',
                'tagSlugs' => ['Premium'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Głośnik Bluetooth',
                'description' => 'Wodoodporny, 12h pracy',
                'slug' => 'glosnik-bluetooth',
                'regularPrice' => '249.00',
                'discountPrice' => null,
                'quantity' => 35,
                'isActive' => true,
                'order' => 13,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'muzyka',
                'tagSlugs' => ['Super Oferta'],
                'deliveryTimeSlug' => 'economy'
            ],
            [
                'name' => 'Kamera sportowa',
                'description' => '4K@60fps, stabilizacja',
                'slug' => 'kamera-sportowa',
                'regularPrice' => '899.00',
                'discountPrice' => '849.00',
                'quantity' => 14,
                'isActive' => true,
                'order' => 14,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'telewizory',
                'tagSlugs' => ['Nowość'],
                'deliveryTimeSlug' => 'express'
            ],
            [
                'name' => 'Torebka skórzana',
                'description' => 'Naturalna skóra licowa',
                'slug' => 'torebka-skorzana', 'regularPrice' => '499.50', 'discountPrice' => null,
                'quantity' => 22,
                'isActive' => true,
                'order' => 15,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'odziez-damska',
                'tagSlugs' => ['Limitowana Edycja'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Buty trekkingowe',
                'description' => 'Gore-Tex, podeszwa Vibram',
                'slug' => 'buty-trekkingowe',
                'regularPrice' => '699.00',
                'discountPrice' => '649.00',
                'quantity' => 30,
                'isActive' => true,
                'order' => 16,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'odziez-meska',
                'tagSlugs' => ['Premium'],
                'deliveryTimeSlug' => 'economy'
            ],
            [
                'name' => 'Paleta farb akwarelowych',
                'description' => '12 kolorów trwałych',
                'slug' => 'paleta-farb-akwarelowych',
                'regularPrice' => '89.99',
                'discountPrice' => null,
                'quantity' => 75,
                'isActive' => true,
                'order' => 17,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'narzedzia',
                'tagSlugs' => ['Nowość'],
                'deliveryTimeSlug' => 'standard'
            ],
            [
                'name' => 'Stojak na wino',
                'description' => 'Drewniany stojak na 6 butelek',
                'slug' => 'stojak-na-wino',
                'regularPrice' => '259.00',
                'discountPrice' => '239.00',
                'quantity' => 27,
                'isActive' => true,
                'order' => 18, '
                created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'meble',
                'tagSlugs' => ['Super Oferta'],
                'deliveryTimeSlug' => 'express'
            ],
            [
                'name' => 'Puzzle 1000 elementów',
                'description' => 'Widok górskiego krajobrazu',
                'slug' => 'puzzle-1000-elementow',
                'regularPrice' => '69.90',
                'discountPrice' => null,
                'quantity' => 120,
                'isActive' => true,
                'order' => 19,
                'created_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'updated_at' => new \DateTime('-' . random_int(0, 365) . ' days'),
                'categorySlug' => 'ksiazki',
                'tagSlugs' => ['Limitowana Edycja'],
                'deliveryTimeSlug' => 'standard'
            ],
        ];
    }
}
