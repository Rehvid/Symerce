<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Persisters\Admin\Category\CategoryCreatePersister;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends ApiTestCase
{
    public function testIndexSuccessfully(): void
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

        $createPersister->persist($persist);

        $this->sendJsonRequest(Request::METHOD_GET, '/api/admin/categories');
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);

        $this->assertArrayHasKey('page', $data['meta']);
        $this->assertArrayHasKey('limit', $data['meta']);
        $this->assertArrayHasKey('totalItems', $data['meta']);
        $this->assertArrayHasKey('totalPages', $data['meta']);
        $this->assertArrayHasKey('offset', $data['meta']);

        $this->assertNotEmpty($data['data']);
    }

    public function testIndexWithEmptyCategory(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_GET, '/api/admin/categories');
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);

        $data = $this->getJsonResponseData();
        $this->assertIsApiResponse($data);

        $this->assertArrayHasKey('page', $data['meta']);
        $this->assertArrayHasKey('limit', $data['meta']);
        $this->assertArrayHasKey('totalItems', $data['meta']);
        $this->assertArrayHasKey('totalPages', $data['meta']);
        $this->assertArrayHasKey('offset', $data['meta']);

        $this->assertEmpty($data['data']);
    }
}
