<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\DTO\Request\OrderRequestDTO;
use App\DTO\Response\DeliveryTime\DeliveryTimeIndexResponseDTO;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Mapper\DeliveryTimeResponseMapper;
use App\Repository\DeliveryTimeRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ResponseService;
use App\Service\SortableEntityOrderUpdater;
use App\Utils\Utils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/delivery-time', name: 'delivery_time_')]
class DeliveryTimeController extends AbstractAdminController
{
    public function __construct(
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
        PaginationService $paginationService,
        SortableEntityOrderUpdater $sortableEntityOrderUpdater,
        private readonly DeliveryTimeResponseMapper $deliveryTimeResponseMapper,
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
    public function index(Request $request, DeliveryTimeRepository $repository): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $repository);
        $data = array_map(function (DeliveryTime $deliveryTime) {
            $type = $this->translator->trans("base.delivery_type.{$deliveryTime->getType()->value}");

            return DeliveryTimeIndexResponseDTO::fromArray([
                'id' => $deliveryTime->getId(),
                'label' => $deliveryTime->getLabel(),
                'minDays' => $deliveryTime->getMinDays(),
                'maxDays' => $deliveryTime->getMaxDays(),
                'type' => $type,
            ]);
        }, $paginatedResponse->data);

        $additionalData = [
            'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
        ];

        return $this->prepareJsonResponse(
            data: array_merge($data, ['additionalData' => $additionalData]),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function showStoreFormData(): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: $this->deliveryTimeResponseMapper->mapToStoreFormDataResponse(),
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(DeliveryTime $deliveryTime): JsonResponse
    {
        return $this->prepareJsonResponse(
            $this->deliveryTimeResponseMapper->mapToUpdateFormDataResponse(['deliveryTime' => $deliveryTime])
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(#[MapRequestPayload] SaveDeliveryTimeRequestDTO $persistable): JsonResponse
    {
        /** @var DeliveryTime $entity */
        $entity = $this->dataPersisterManager->persist($persistable);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.delivery_time.store'),
            statusCode: Response::HTTP_CREATED
        );
    }

    #[Route('/order', name: 'order', methods: ['PUT'])]
    public function order(#[MapRequestPayload] OrderRequestDTO $orderRequestDTO): JsonResponse
    {
        return $this->sortOrderForEntity($orderRequestDTO, DeliveryTime::class);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        DeliveryTime $deliveryTime,
        #[MapRequestPayload] SaveDeliveryTimeRequestDTO $persistable,
    ): JsonResponse {
        /** @var DeliveryTime $entity */
        $entity = $this->dataPersisterManager->update($persistable, $deliveryTime);

        return $this->prepareJsonResponse(
            data: ['id' => $entity->getId()],
            message: $this->translator->trans('base.messages.delivery_time.update')
        );
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(DeliveryTime $currency): JsonResponse
    {
        $this->dataPersisterManager->delete($currency);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.delivery_time.destroy'));
    }

    /**
     * @param array <string, mixed> $types
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForDeliverTypeEnum(array $types): array
    {
        return Utils::buildSelectedOptions(
            items: $types,
            labelCallback: fn (DeliveryType $type) => $this->translator->trans("base.delivery_type.{$type->value}"),
            valueCallback: fn (DeliveryType $type) => $type->value,
        );
    }
}
