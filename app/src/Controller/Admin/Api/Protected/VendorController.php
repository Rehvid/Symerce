<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Vendor\SaveVendorRequestDTO;
use App\Entity\Vendor;
use App\Mapper\VendorResponseMapper;
use App\Repository\VendorRepository;
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

#[Route('/vendors', name: 'vendor_')]
class VendorController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly VendorResponseMapper $vendorResponseMapper
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
    public function index(Request $request, VendorRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->vendorResponseMapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveVendorRequestDTO $persistable): JsonResponse
    {
        /** @var Vendor $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Vendor $vendor): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->vendorResponseMapper->mapToUpdateFormDataResponse(['vendor' => $vendor])
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Vendor $vendor,
        #[MapRequestPayload] SaveVendorRequestDTO $persistable,
    ): JsonResponse {
        /** @var Vendor $entity */
        $entity = $this->dataPersisterManager->update($persistable, $vendor);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.vendor.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Vendor $vendor): JsonResponse
    {
        $this->dataPersisterManager->delete($vendor);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.vendor.destroy'));
    }
}
