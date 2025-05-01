<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\Entity\Carrier;
use App\Mapper\CarrierResponseMapper;
use App\Repository\CarrierRepository;
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

#[Route('/carriers', name: 'carrier_')]
class CarrierController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly CarrierResponseMapper $carrierResponseMapper,
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
    public function index(
        Request $request,
        CarrierRepository $repository,
    ): JsonResponse {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->carrierResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Carrier $carrier): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->carrierResponseMapper->mapToUpdateFormDataResponse(['carrier' => $carrier])
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
