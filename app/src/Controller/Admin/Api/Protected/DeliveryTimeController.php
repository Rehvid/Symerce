<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractAdminController;
use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\DTO\Request\OrderRequestDTO;
use App\DTO\Response\DeliveryTime\DeliveryTimeFormResponseDTO;
use App\DTO\Response\DeliveryTime\DeliveryTimeIndexResponseDTO;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Repository\DeliveryTimeRepository;
use App\Utils\Utils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/delivery-time', name: 'delivery_time_')]
class DeliveryTimeController extends AbstractAdminController
{
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

        return $this->prepareJsonResponse(
            data: $data,
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function showStoreFormData(): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => DeliveryTimeFormResponseDTO::fromArray([
                    'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
                ]),
            ]
        );
    }

    #[Route('/{id}/form-data', name: 'update_form_data', methods: ['GET'])]
    public function showUpdateFormData(DeliveryTime $deliveryTime): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'formData' => DeliveryTimeFormResponseDTO::fromArray([
                    'label' => $deliveryTime->getLabel(),
                    'minDays' => $deliveryTime->getMinDays(),
                    'maxDays' => $deliveryTime->getMaxDays(),
                    'type' => $deliveryTime->getType()->value,
                    'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
                ]),
            ]
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
