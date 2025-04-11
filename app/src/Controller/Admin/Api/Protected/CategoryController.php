<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\DTO\Request\OrderRequestDTO;
use App\DTO\Response\Category\CategoryFormResponseDTO;
use App\DTO\Response\Category\CategoryIndexResponseDTO;
use App\DTO\Response\FileResponseDTO;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\CategoryTreeBuilder;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'category_')]
class CategoryController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, CategoryRepository $repository): JsonResponse
    {
        return $this->getPaginatedResponse($request, $repository, CategoryIndexResponseDTO::class);
    }

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function storeUpdateFormData(CategoryTreeBuilder $treeBuilder): JsonResponse
    {
        $data = CategoryFormResponseDTO::fromArray([
            'tree' => $treeBuilder->generateTree(),
        ]);

        return $this->prepareJsonResponse(data: ['formData' => $data]);
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Category $category, CategoryTreeBuilder $treeBuilder, FileService $service): JsonResponse
    {

        $dataResponse = [
            'tree' => $treeBuilder->generateTree(),
            'name' => $category->getName(),
            'parentCategoryId' => $category->getParent()?->getId(),
            'description' => $category->getDescription(),
            'isActive' => $category->isActive(),
        ];

        if ($category->getImage()) {
            $dataResponse['image'] = FileResponseDTO::fromArray([
                'id' => $category->getImage()->getId(),
                'originalName' => $category->getImage()->getOriginalName(),
                'path' => $service->preparePublicPathToFile($category->getImage()),
            ]);
        }

        return $this->prepareJsonResponse(data: ['formData' => CategoryFormResponseDTO::fromArray($dataResponse)]);
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveCategoryRequestDTO $dto): JsonResponse
    {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.category.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/order', name: 'order', methods: ['PUT'])]
    public function order(#[MapRequestPayload] OrderRequestDTO $orderRequestDTO): JsonResponse
    {
        return $this->sortOrderForEntity($orderRequestDTO, Category::class);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Category $category,
        #[MapRequestPayload] SaveCategoryRequestDTO $dto,
    ): JsonResponse {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->update($dto, $category);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.category.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Category $category): JsonResponse
    {
        $this->dataPersisterManager->delete($category);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.category.destroy'));
    }
}
