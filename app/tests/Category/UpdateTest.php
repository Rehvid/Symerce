<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\Factory\PersistableDTOFactory;
use App\Repository\CategoryRepository;
use App\Service\DataPersister\Persisters\Category\CategoryCreatePersister;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateTest extends ApiTestCase
{
    public function testUpdateCategorySuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $createPersister = self::getContainer()->get(CategoryCreatePersister::class);

        $persist = PersistableDTOFactory::create(SaveCategoryRequestDTO::class, [
            'name' => 'T-shirt',
            'isActive' => true,
            'parentCategoryId' => null,
            'description' => null,
        ]);

        $category = $createPersister->persist($persist);

        $this->sendJsonRequest(Request::METHOD_PUT,"/api/admin/categories/{$category->getId()}", [
            'name' => 'Trousers',
            'isActive' => true,
            'parentCategoryId' => null,
            'description' => null,
        ]);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $category = self::getContainer()->get(CategoryRepository::class)->find($category->getId());
        $this->assertNotNull($category);

        $this->assertEquals('Trousers', $category->getName());
    }

    public function testUpdateCategoryFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $createPersister = self::getContainer()->get(CategoryCreatePersister::class);

        $persist = PersistableDTOFactory::create(SaveCategoryRequestDTO::class, [
            'name' => 'T-shirt',
            'isActive' => true,
            'parentCategoryId' => null,
            'description' => null,
        ]);

        $category = $createPersister->persist($persist);

        $this->sendJsonRequest(Request::METHOD_PUT,"/api/admin/categories/{$category->getId()}", [
            'name' => 'Trousers',
            'parentCategoryId' => null,
            'description' => null,
        ]);

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}
