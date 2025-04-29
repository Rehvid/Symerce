<?php

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\Setting\SaveSettingRequestDTO;
use App\DTO\Response\Setting\SettingFormResponseDTO;
use App\DTO\Response\Setting\SettingIndexResponseDTO;
use App\DTO\Response\Setting\SettingUpdateFormResponseDTO;
use App\DTO\Response\Setting\SettingValueFormResponseDTO;
use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Enums\SettingValueType;
use App\Mapper\SettingMapper;
use App\Repository\SettingRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
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
        private readonly EntityManagerInterface $entityManager,
        private readonly SettingMapper $mapper,
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

        $additionalData = [
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::cases()),
        ];

        return $this->prepareJsonResponse(
            data: array_merge($this->mapper->mapToIndex($paginatedResponse->data), ['additionalData' => $additionalData]),
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
            data: [
                'formData' => SettingFormResponseDTO::fromArray([
                    'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
                ]),
            ]
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(Setting $setting): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => $this->mapper->mapToShowUpdateFormData($setting),
            ]
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

    /**
     * @param array <string, mixed> $types
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForSettingTypeEnum(array $types): array
    {
        return Utils::buildSelectedOptions(
            items: $types,
            labelCallback: fn (SettingType $type) => $this->translator->trans("base.setting_type.{$type->value}"),
            valueCallback: fn (SettingType $type) => $type->value,
        );
    }
}
