<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\DeliveryTime\DeliveryTimeFormResponseDTO;
use App\DTO\Response\DeliveryTime\DeliveryTimeIndexResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Utils\Utils;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class DeliveryTimeResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
        private TranslatorInterface $translator,
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        $deliveryData = array_map(
            fn (DeliveryTime $deliveryTime) => $this->createDeliveryTimeIndexResponse($deliveryTime),
            $data
        );

        $additionalData = [
            'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
        ];

        return $this->responseMapperHelper->prepareIndexFormDataResponse($deliveryData, $additionalData);
    }

    private function createDeliveryTimeIndexResponse(DeliveryTime $deliveryTime): ResponseInterfaceData
    {
        $type = $this->translator->trans("base.delivery_type.{$deliveryTime->getType()->value}");

        return DeliveryTimeIndexResponseDTO::fromArray([
            'id' => $deliveryTime->getId(),
            'label' => $deliveryTime->getLabel(),
            'minDays' => $deliveryTime->getMinDays(),
            'maxDays' => $deliveryTime->getMaxDays(),
            'type' => $type,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function mapToStoreFormDataResponse(): array
    {
        $response = DeliveryTimeFormResponseDTO::fromArray([
            'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var DeliveryTime $deliveryTime */
        $deliveryTime = $data['entity'];

        $response = DeliveryTimeFormResponseDTO::fromArray([
            'label' => $deliveryTime->getLabel(),
            'minDays' => $deliveryTime->getMinDays(),
            'maxDays' => $deliveryTime->getMaxDays(),
            'type' => $deliveryTime->getType()->value,
            'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(DeliveryType::translatedOptions()),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForDeliverTypeEnum(array $options): array
    {
        return Utils::buildSelectedOptions(
            items: $options,
            labelCallback: fn (DeliveryType $type) => $this->translator->trans("base.delivery_type.{$type->value}"),
            valueCallback: fn (DeliveryType $type) => $type->value,
        );
    }
}
