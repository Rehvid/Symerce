<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\DeliveryTime\DeliveryTimeCreateFormResponse;
use App\Admin\Application\DTO\Response\DeliveryTime\DeliveryTimeFormResponse;
use App\Admin\Application\DTO\Response\DeliveryTime\DeliveryTimeListResponse;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Enums\DeliveryType;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class DeliveryTimeAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $collection = array_map(
            fn (DeliveryTime $deliveryTime) => $this->createDeliveryTimeListResponse($deliveryTime),
            $paginatedData
        );

        $additionalData = [
            'types' => $this->buildTranslatedOptionsForDeliverTypeEnum(),
        ];

        return $this->responseHelperAssembler->wrapListWithAdditionalData($collection, $additionalData);
    }

    public function toCreateFormDataResponse(): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new DeliveryTimeCreateFormResponse(
                availableTypes: $this->buildTranslatedOptionsForDeliverTypeEnum(),
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(DeliveryTime $deliveryTime): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new DeliveryTimeFormResponse(
                label: $deliveryTime->getLabel(),
                minDays: $deliveryTime->getMinDays(),
                maxDays: $deliveryTime->getMaxDays(),
                type: $deliveryTime->getType()->value,
                isActive: $deliveryTime->isActive(),
                availableTypes: $this->buildTranslatedOptionsForDeliverTypeEnum()
            )
        );
    }

    private function createDeliveryTimeListResponse(DeliveryTime $deliveryTime): DeliveryTimeListResponse
    {
        return new DeliveryTimeListResponse(
            id: $deliveryTime->getId(),
            label: $deliveryTime->getLabel(),
            minDays: $deliveryTime->getMinDays(),
            maxDays: $deliveryTime->getMaxDays(),
            type: $deliveryTime->getType()->value
        );
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForDeliverTypeEnum(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: DeliveryType::translatedOptions(),
            labelCallback: fn (DeliveryType $type) => $this->translator->trans("base.delivery_type.{$type->value}"),
            valueCallback: fn (DeliveryType $type) => $type->value,
        );
    }
}
