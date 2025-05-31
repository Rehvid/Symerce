<?php

declare(strict_types=1);

namespace App\Tests\Category;

use App\Admin\Domain\Entity\Category;
use App\Category\Infrastructure\Repository\CategoryDoctrineRepository;
use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\Factory\PersistableDTOFactory;
use App\Service\DataPersister\Persisters\Admin\Category\CategoryCreatePersister;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DestroyTest extends ApiTestCase
{
    public function testDestroyCategorySuccessfully(): void
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

        /** @var Category $category */
        $category = $createPersister->persist($persist);
        $id = $category->getId();

        $this->sendJsonRequest(Request::METHOD_DELETE, "/api/admin/categories/$id");

        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);
        $this->assertIsApiResponse($this->getJsonResponseData());

        $result = self::getContainer()->get(CategoryDoctrineRepository::class)->find($category->getId());
        $this->assertNull($result);
    }

    public function testDestroyCategoryFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_DELETE, "/api/admin/categories/1");

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
