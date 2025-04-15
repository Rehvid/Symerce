<?php

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\DTO\Response\AttributeValue\AttributeValueFormResponseDTO;
use App\Entity\AttributeValue;
use App\Repository\AttributeRepository;
use App\Repository\AttributeValueRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attributes/{attributeId}/values', name: 'attribute_value_')]
class AttributeValueController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, AttributeValueRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $paginatedResponse->data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveAttributeValueRequestDTO $dto): JsonResponse
    {
        /** @var AttributeValue $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.category.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(AttributeValue $attribute): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => AttributeValueFormResponseDTO::fromArray([
                    'value' => $attribute->getValue()
                ])
            ]
        );
    }


    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        AttributeValue $attribute,
        #[MapRequestPayload] SaveAttributeValueRequestDTO $dto,
    ): JsonResponse {
        /** @var AttributeValue $entity */
        $entity = $this->dataPersisterManager->update($dto, $attribute);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.category.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(AttributeValue $attribute): JsonResponse
    {
        $this->dataPersisterManager->delete($attribute);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.category.destroy'));
    }
}
