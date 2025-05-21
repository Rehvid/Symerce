<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\AttributeValue\SaveAttributeValueRequest;
use App\Admin\Domain\Entity\AttributeValue;

final readonly class AttributeValueHydrator
{
    public function hydrate(SaveAttributeValueRequest $request, AttributeValue $attributeValue): AttributeValue
    {
        $attributeValue->setValue($request->value);

        return $attributeValue;
    }
}
