<?php

declare (strict_types = 1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\DTO\Response\Carrier\CarrierFormResponseDTO;
use App\DTO\Response\Carrier\CarrierIndexResponseDTO;
use App\DTO\Response\FileResponseDTO;
use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carriers', name: 'carrier_')]
class CarrierController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, CarrierRepository $repository, FileService $service): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $data = array_map(function (array $item) use ($service) {
            return CarrierIndexResponseDTO::fromArray([
                'id' => $item['id'],
                'name' => $item['name'],
                'isActive' => $item['isActive'],
                'fee' => $item['fee'],
                'imagePath' => $service->preparePublicPathToFile($item['path']),
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Carrier $carrier, FileService $service): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => CarrierFormResponseDTO::fromArray([
                    'name' => $carrier->getName(),
                    'fee' => $carrier->getFee(),
                    'isActive' => $carrier->isActive(),
                    'image' => FileResponseDTO::fromArray([
                        'id' => $carrier->getImage()?->getId(),
                        'name' => "Avatar - {$carrier->getName()}",
                        'preview' => $service->preparePublicPathToFile($carrier->getImage()?->getPath()),
                    ])
                ])
            ]
        );
    }


    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveCarrierRequestDTO $dto): JsonResponse
    {
        $entity = $this->dataPersisterManager->persist($dto);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Carrier $carrier,
        #[MapRequestPayload] SaveCarrierRequestDTO $dto,
    ): JsonResponse {

        $entity = $this->dataPersisterManager->update($dto, $carrier);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Carrier $carrier): JsonResponse
    {
        $this->dataPersisterManager->delete($carrier);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.vendor.destroy'));
    }
}
