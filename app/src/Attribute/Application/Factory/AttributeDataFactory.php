<?php

declare(strict_types = 1);

namespace App\Attribute\Application\Factory;

use App\Attribute\Application\Dto\AttributeData;
use App\Attribute\Application\Dto\Request\SaveAttributeRequest;
use App\Attribute\Domain\Enums\AttributeType;

final readonly class AttributeDataFactory
{
    public function fromRequest(SaveAttributeRequest $attributeRequest): AttributeData
    {
        return new AttributeData(
            name: $attributeRequest->name,
            type: AttributeType::from($attributeRequest->type),
            isActive: $attributeRequest->isActive,
        );
    }
}
