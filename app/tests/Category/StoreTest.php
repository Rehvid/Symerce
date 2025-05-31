<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\Category\Infrastructure\Repository\CategoryDoctrineRepository;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreTest extends ApiTestCase
{
    public function testStoreCategorySuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_POST, '/api/admin/categories', [
            'name' => 'T-shirt',
            'isActive' => true,
            'parentCategoryId' => null,
            'description' => 'Cool t-shirt',
        ]);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_CREATED);

        $category = self::getContainer()->get(CategoryDoctrineRepository::class)->findOneBy(['name' => 'T-shirt']);
        $this->assertNotNull($category);
    }

    public function testStoreCategoryFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_POST, '/api/admin/categories', [
            'name' => 'T-shirt',
            'parentCategoryId' => null,
            'description' => 'Cool t-shirt',
        ]);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
