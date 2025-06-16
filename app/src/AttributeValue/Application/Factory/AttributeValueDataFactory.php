<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Factory;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\AttributeValue\Application\Dto\AttributeValueData;
use App\AttributeValue\Application\Dto\Request\SaveAttributeValueRequest;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class AttributeValueDataFactory
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {}

    public function fromRequest(SaveAttributeValueRequest $attributeValueRequest): AttributeValueData
    {
        /** @var ?Attribute $attribute */
        $attribute = $this->attributeRepository->findById($attributeValueRequest->attributeIdRequest->getId());
        if (null === $attribute) {
            throw EntityNotFoundException::for(AttributeValue::class, $attributeValueRequest->attributeIdRequest->getId());
        }

        return new AttributeValueData(
            value: $attributeValueRequest->value,
            attribute: $attribute
        );
    }
}
