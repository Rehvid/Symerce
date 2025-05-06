<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Persisters\Admin\Category\CategoryCreatePersister;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormDataTest extends ApiTestCase
{
    public function testFormDataSuccessfully(): void
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

        $this->sendJsonRequest(Request::METHOD_GET, "/api/admin/categories/{$category->getId()}/form-data");

        $data = $this->getJsonResponseData();

        $this->assertIsApiResponse($data);

        $this->assertArrayHasKey('tree', $data['data']['formData']);
        $this->assertArrayHasKey('name', $data['data']['formData']);
        $this->assertArrayHasKey('parentCategoryId', $data['data']['formData']);
        $this->assertArrayHasKey('description', $data['data']['formData']);
        $this->assertArrayHasKey('isActive', $data['data']['formData']);

        $this->assertNotEmpty($data['data']['formData']['tree']);
        $this->assertNotNull($data['data']['formData']['name']);
    }

    public function testFormDataFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_GET, "/api/admin/categories/1/form-data");


        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $this->assertArrayHasKey('tree', $data['data']['formData']);
        $this->assertArrayHasKey('name', $data['data']['formData']);
        $this->assertArrayHasKey('parentCategoryId', $data['data']['formData']);
        $this->assertArrayHasKey('description', $data['data']['formData']);
        $this->assertArrayHasKey('isActive', $data['data']['formData']);

        $this->assertEmpty($data['data']['formData']['tree']);
        $this->assertNull($data['data']['formData']['name']);
    }
}
