<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\DTO\Request\OrderRequestDTO;
use App\Entity\Attribute;
use App\Mapper\AttributeResponseMapper;
use App\Repository\AttributeRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/attributes', name: 'attribute_')]
class AttributeController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly AttributeResponseMapper $attributeResponseMapper,
    ) {
        parent::__construct($dataPersisterManager, $translator, $responseService, $paginationService, $sortableEntityOrderUpdater);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, AttributeRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->attributeResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveAttributeRequestDTO $persistable): JsonResponse
    {
        /** @var Attribute $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.attribute.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/order', name: 'order', methods: ['PUT'])]
    public function order(#[MapRequestPayload] OrderRequestDTO $orderRequestDTO): JsonResponse
    {
        return $this->sortOrderForEntity($orderRequestDTO, Attribute::class);
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Attribute $attribute): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->attributeResponseMapper->mapToUpdateFormDataResponse(['attribute' => $attribute]),
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Attribute $attribute,
        #[MapRequestPayload] SaveAttributeRequestDTO $persistable,
    ): JsonResponse {
        /** @var Attribute $entity */
        $entity = $this->dataPersisterManager->update($persistable, $attribute);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.attribute.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Attribute $attribute): JsonResponse
    {
        $this->dataPersisterManager->delete($attribute);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.attribute.destroy'));
    }
}
