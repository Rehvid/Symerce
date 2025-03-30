<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Controller\AbstractApiController;
use App\Dto\Request\Category\SaveCategoryRequestDTO;
use App\Dto\Response\Category\CategoryFormResponseDTO;
use App\Dto\Response\Category\CategoryListResponseDTO;
use App\Entity\Category;
use App\Service\CategoryTreeBuilder;
use App\Service\Pagination\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractApiController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getList(Request $request, PaginationService $paginationService): JsonResponse
    {
        $paginationResponse = $paginationService->createResponse($request);

        return $this->prepareJsonResponse(
            data: array_map(fn ($data) =>  CategoryListResponseDTO::fromArray($data), $paginationResponse->data),
            meta: $paginationResponse->paginationMeta->toArray()
        );
    }


    #[Route('/form-data/{id?}', name: 'form_data', defaults: ['id' => null], methods: ['GET'])]
    public function getFormData(?Category $category, CategoryTreeBuilder $treeBuilder): JsonResponse
    {
        $data = CategoryFormResponseDTO::fromArray([
            'tree' => $treeBuilder->generateTree(),
            'name' => $category?->getName(),
            'parentCategoryId' => $category?->getParent()?->getId(),
            'description' => $category?->getDescription(),
            'isActive' => $category && $category->isActive(),
        ]);

        return $this->prepareJsonResponse($data);
    }

    #[Route('/create', name: 'create', methods: ['POST'], format: 'json')]
    public function create(#[MapRequestPayload] SaveCategoryRequestDTO $dto): JsonResponse
    {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/update', name: 'update', methods: ['PUT'])]
    public function update(
        Category                                    $category,
        #[MapRequestPayload] SaveCategoryRequestDTO $dto,
    ): JsonResponse {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->update($category, $dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
        );
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Category $category): JsonResponse
    {
        $this->dataPersisterManager->delete($category);

        return $this->prepareJsonResponse();
    }
}
