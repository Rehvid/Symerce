<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\Entity\Setting;
use App\Mapper\SettingResponseMapper;
use App\Repository\SettingRepository;
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

#[Route('/settings', name: 'setting_')]
class SettingsController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly SettingResponseMapper $mapper,
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
    public function index(Request $request, SettingRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);

        return $this->prepareJsonResponse(
            data: $this->mapper->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveSettingRequestDTO $persistable): JsonResponse
    {
        /** @var Setting $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.settings.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function showStoreFormData(): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->mapper->mapToStoreFormDataResponse()
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Setting $setting): JsonResponse
    {
        return $this->prepareJsonResponse(
            $this->mapper->mapToUpdateFormDataResponse(['setting' => $setting]),
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Setting $setting,
        #[MapRequestPayload] SaveSettingRequestDTO $persistable,
    ): JsonResponse {
        /** @var Setting $entity */
        $entity = $this->dataPersisterManager->update($persistable, $setting);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.settings.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Setting $settings): JsonResponse
    {
        $this->dataPersisterManager->delete($settings);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.settings.destroy'));
    }
}
