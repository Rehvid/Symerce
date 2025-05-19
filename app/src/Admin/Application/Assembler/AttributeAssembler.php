<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Attribute\AttributeFormResponse;
use App\Admin\Application\DTO\Response\Attribute\AttributeListResponse;
use App\Entity\Attribute;

final readonly class AttributeAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $attributeCollection = array_map(fn (Attribute $attribute) => $this->createAttributeListResponse($attribute), $paginatedData);

        return $this->responseHelperAssembler->wrapListWithAdditionalData($attributeCollection);
    }

    public function toFormDataResponse(Attribute $attribute): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new AttributeFormResponse(
                name: $attribute->getName(),
            ),
        );
    }

    private function createAttributeListResponse(Attribute $attribute): AttributeListResponse
    {
        return new AttributeListResponse(
            id: $attribute->getId(),
            name: $attribute->getName(),
        );
    }
}
