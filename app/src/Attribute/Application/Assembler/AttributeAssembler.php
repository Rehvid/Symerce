<?php

declare(strict_types=1);

namespace App\Attribute\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Attribute\Application\Dto\Response\AttributeFormContextResponse;
use App\Attribute\Application\Dto\Response\AttributeFormResponse;
use App\Attribute\Application\Dto\Response\AttributeListResponse;
use App\Attribute\Domain\Enums\AttributeType;
use App\Common\Domain\Entity\Attribute;

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
        return $this->responseHelperAssembler->wrapFormResponse(
            data: new AttributeFormResponse(
                name: $attribute->getName(),
                type: $attribute->getType()->value,
                isActive: $attribute->isActive()
            ),
            context: $this->createFormContextResponse()
        );
    }

    public function toFormContextResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            context: $this->createFormContextResponse()
        );
    }

    private function createFormContextResponse(): AttributeFormContextResponse
    {
        return new AttributeFormContextResponse(
            availableTypes: $this->getAvailableTypes()
        );
    }

    private function getAvailableTypes(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: AttributeType::cases(),
            labelCallback: fn (AttributeType $type) => $type->value,
            valueCallback: fn (AttributeType $type) => $type->value,
        );
    }

    private function createAttributeListResponse(Attribute $attribute): AttributeListResponse
    {
        return new AttributeListResponse(
            id: $attribute->getId(),
            name: $attribute->getName(),
            isActive: $attribute->isActive()
        );
    }
}
