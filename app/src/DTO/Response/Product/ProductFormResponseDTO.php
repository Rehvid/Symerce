<?php

declare(strict_types=1);

namespace App\DTO\Response\Product;

use App\DTO\Response\ResponseInterfaceData;

class ProductFormResponseDTO implements ResponseInterfaceData
{
    /**
     * @param array<int, mixed> $optionTags
     * @param array<int, mixed> $optionCategories
     * @param array<int, mixed> $optionVendors
     * @param array<int, mixed> $optionDeliveryTimes
     * @param array<int, mixed> $optionAttributes
     */
    protected function __construct(
        public ?array $optionTags,
        public ?array $optionCategories,
        public ?array $optionVendors,
        public ?array $optionDeliveryTimes,
        public ?array $optionAttributes,
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            optionTags: $data['optionTags'],
            optionCategories: $data['optionCategories'],
            optionVendors: $data['optionVendors'],
            optionDeliveryTimes: $data['optionDeliveryTimes'],
            optionAttributes: $data['optionAttributes'],
        );
    }
}
