<?php

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\DTO\Response\AttributeValue\AttributeValueFormResponseDTO;
use App\DTO\Response\AttributeValue\AttributeValueIndexResponseDTO;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Repository\AttributeRepository;
use App\Repository\AttributeValueRepository;
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

#[Route('/attributes/{attributeId}/values', name: 'attribute_value_')]
class AttributeValueController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly AttributeRepository $attributeRepository,
    ) {
        parent::__construct($dataPersisterManager, $translator, $responseService, $paginationService, $sortableEntityOrderUpdater);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, AttributeValueRepository $repository, string $attributeId): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository, ['attributeId' => $attributeId]);

        $data = array_map(function (AttributeValue $attributeValue) {
            return AttributeValueIndexResponseDTO::fromArray([
                'id' => $attributeValue->getId(),
                'value' => $attributeValue->getValue(),
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(
        string $attributeId,
        #[MapRequestPayload] SaveAttributeValueRequestDTO $persistable,
    ): JsonResponse {
        /** @var AttributeValue $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.attribute_value.store', ['%name%' => $this->getAttributeName($attributeId)]),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(AttributeValue $attribute): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => AttributeValueFormResponseDTO::fromArray([
                    'value' => $attribute->getValue(),
                ]),
            ]
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        string $attributeId,
        AttributeValue $attribute,
        #[MapRequestPayload] SaveAttributeValueRequestDTO $persistable,
    ): JsonResponse {
        /** @var AttributeValue $entity */
        $entity = $this->dataPersisterManager->update($persistable, $attribute);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.attribute_value.update', ['%name%' => $this->getAttributeName($attributeId)])
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(string $attributeId, AttributeValue $attribute): JsonResponse
    {
        $this->dataPersisterManager->delete($attribute);

        return $this->prepareJsonResponse(
            message: $this->translator->trans('base.messages.attribute_value.destroy', ['%name%' => $this->getAttributeName($attributeId)])
        );
    }

    private function getAttributeName(string $attributeId): ?string
    {
        /** @var Attribute|null $attribute */
        $attribute = $this->attributeRepository->find($attributeId);

        return $attribute?->getName();
    }
}
