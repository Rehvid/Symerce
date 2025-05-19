<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Attribute\AttributeFormResponse;
use App\Admin\Application\DTO\Response\AttributeValue\AttributeValueFormResponse;
use App\Admin\Application\DTO\Response\AttributeValue\AttributeValueListResponse;
use App\Entity\AttributeValue;

final readonly class AttributeValueAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $attributeValueCollection = array_map(
            fn (AttributeValue $attributeValue) => $this->createAttributeValueListResponse($attributeValue),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($attributeValueCollection);
    }

    public function toFormDataResponse(AttributeValue $attributeValue): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new AttributeValueFormResponse(
                value: $attributeValue->getValue(),
            ),
        );
    }

    private function createAttributeValueListResponse(AttributeValue $attributeValue): AttributeValueListResponse
    {
        return new AttributeValueListResponse(
          id: $attributeValue->getId(),
          value: $attributeValue->getValue(),
        );
    }
}
