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
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\FileService;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/categories', name: 'category_')]
class CategoryController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly FileService $fileService,
    ) {
        parent::__construct(
            $dataPersisterManager,
            $translator,
            $responseService,
            $paginationService,
            $sortableEntityOrderUpdater
        );
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, CategoryRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        /** @var array<int, CategoryIndexResponseDTO> $responseData */
        $responseData = array_map(function ($item) {
            if ($item['path']) {
                $item['imagePath'] = $this->fileService->preparePublicPathToFile($item['path']);
            }

            return CategoryIndexResponseDTO::fromArray($item);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $responseData,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
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
    public function showUpdateFormData(Category $category, CategoryTreeBuilder $tree): JsonResponse
    {
        $name = $category->getName();
        $formData = CategoryFormResponseDTO::fromArray([
            'tree' => $tree->generateTree($category),
            'name' => $name,
            'slug' => $category->getSlug(),
            'parentCategoryId' => $category->getParent()?->getId(),
            'description' => $category->getDescription(),
            'isActive' => $category->isActive(),
            'image' => FileResponseDTO::fromArray([
                'id' => $category->getImage()?->getId(),
                'name' => $name,
                'preview' => $this->fileService->preparePublicPathToFile($category->getImage()?->getPath()),
            ]),
        ]);

        return $this->prepareJsonResponse(data: ['formData' => $formData]);
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveCategoryRequestDTO $persistable): JsonResponse
    {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

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
        #[MapRequestPayload] SaveCategoryRequestDTO $persistable,
    ): JsonResponse {
        /** @var Category $entity */
        $entity = $this->dataPersisterManager->update($persistable, $category);

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
