<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\DTO\Response\Carrier\CarrierFormResponseDTO;
use App\DTO\Response\Carrier\CarrierIndexResponseDTO;
use App\DTO\Response\FileResponseDTO;
use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use App\Service\FileService;
use App\Service\SettingManager;
use App\ValueObject\Money;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carriers', name: 'carrier_')]
class CarrierController extends AbstractAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(
        Request $request,
        CarrierRepository $repository,
        SettingManager $settingManager,
        FileService $service
    ): JsonResponse {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        $defaultCurrency = $settingManager->findDefaultCurrency();

        $data = array_map(function (Carrier $carrier) use ($service, $defaultCurrency) {
            return CarrierIndexResponseDTO::fromArray([
                'id' => $carrier->getId(),
                'name' => $carrier->getName(),
                'isActive' => $carrier->isActive(),
                'fee' => new Money($carrier->getFee(), $defaultCurrency),
                'imagePath' => $service->preparePublicPathToFile($carrier->getImage()?->getPath()),
            ]);
        }, $paginatedResponse->data);

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Carrier $carrier, FileService $service, SettingManager $settingManager): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => CarrierFormResponseDTO::fromArray([
                    'name' => $carrier->getName(),
                    'fee' => new Money($carrier->getFee(), $settingManager->findDefaultCurrency()),
                    'isActive' => $carrier->isActive(),
                    'image' => FileResponseDTO::fromArray([
                        'id' => $carrier->getImage()?->getId(),
                        'name' => "Avatar - {$carrier->getName()}",
                        'preview' => $service->preparePublicPathToFile($carrier->getImage()?->getPath()),
                    ]),
                ]),
            ]
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveCarrierRequestDTO $persistable): JsonResponse
    {
        /** @var Carrier $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.carrier.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Carrier $carrier,
        #[MapRequestPayload] SaveCarrierRequestDTO $persistable,
    ): JsonResponse {
        /** @var Carrier $entity */
        $entity = $this->dataPersisterManager->update($persistable, $carrier);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.carrier.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Carrier $carrier): JsonResponse
    {
        $this->dataPersisterManager->delete($carrier);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.carrier.destroy'));
    }
}
