<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\Admin\Infrastructure\Repository\CategoryDoctrineRepository;
use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Persisters\Admin\Category\CategoryCreatePersister;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderTest extends ApiTestCase
{
    public function testStoreCategorySuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $categoryIds = $this->createCategories();

        $newOrder = [];
        $newOrder[] = $categoryIds[2];
        $newOrder[] = $categoryIds[0];
        $newOrder[] = $categoryIds[1];
        $newOrder[] = $categoryIds[4];
        $newOrder[] = $categoryIds[3];

        $newOrderMap = array_flip($newOrder);

        $this->sendJsonRequest(Request::METHOD_PUT, '/api/admin/categories/order', [
            'order' => $newOrder,
        ]);

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $categories = self::getContainer()->get(CategoryDoctrineRepository::class)->findAll();
        foreach ($categories as $category) {
            $this->assertEquals($category->getOrder(), $newOrderMap[$category->getId()]);
        }
    }

    private function createCategories(): array
    {
        $createPersister = self::getContainer()->get(CategoryCreatePersister::class);

        $categoryIds = [];
        for ($i = 0; $i < 5; $i++) {
            $persist = PersistableDTOFactory::create(SaveCategoryRequestDTO::class, [
                'name' => "T-Shirt-$i",
                'isActive' => true,
                'parentCategoryId' => null,
                'description' => null,
            ]);
            $category = $createPersister->persist($persist);
            $categoryIds[] = $category->getId();
        }

        return $categoryIds;
    }

    public function testOrderCategoryFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_PUT, '/api/admin/categories/order');

        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
