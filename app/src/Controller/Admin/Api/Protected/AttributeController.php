<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\DTO\Response\Attribute\AttributeFormResponseDTO;
use App\DTO\Response\Attribute\AttributeIndexResponseDTO;
use App\Entity\Attribute;
use App\Repository\AttributeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attributes', name: 'attribute_')]
class AttributeController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, AttributeRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $data = array_map(function (array $item) {
            return AttributeIndexResponseDTO::fromArray([
                'id' => $item['id'],
                'name' => $item['name'],
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveAttributeRequestDTO $dto,): JsonResponse
    {
        /** @var Attribute $entity */
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.attribute.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Attribute $attribute): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => AttributeFormResponseDTO::fromArray([
                    'name' => $attribute->getName()
                ])
            ]
        );
    }


    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Attribute $attribute,
        #[MapRequestPayload] SaveAttributeRequestDTO $dto,
    ): JsonResponse {
        /** @var Attribute $entity */
        $entity = $this->dataPersisterManager->update($dto, $attribute);

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
