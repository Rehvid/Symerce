<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Product\SaveProductRequestDTO;
use App\Entity\Product;
use App\Mapper\ProductMapper;
use App\Repository\ProductRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/products', name: 'products_')]
class ProductController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly ProductMapper $mapper,
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
    public function index(Request $request, ProductRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->mapper->mapToIndex($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function storeUpdateFormData(): JsonResponse
    {
        return $this->prepareJsonResponse(data: ['formData' => $this->mapper->mapToStoreFormData()]);
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Product $product): JsonResponse
    {
        return $this->prepareJsonResponse(data: ['formData' => $this->mapper->mapToUpdateFormData($product)]);
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveProductRequestDTO $persistable): JsonResponse
    {
        /** @var Product $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.product.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Product $product,
        #[MapRequestPayload] SaveProductRequestDTO $persistable
    ): JsonResponse {
        /** @var Product $entity */
        $entity = $this->dataPersisterManager->update($persistable, $product);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.product.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Product $product): JsonResponse
    {
        $this->dataPersisterManager->delete($product);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.product.destroy'));
    }
}
