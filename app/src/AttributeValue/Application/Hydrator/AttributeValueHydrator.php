<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Hydrator;

use App\AttributeValue\Application\Dto\AttributeValueData;
use App\Common\Domain\Entity\AttributeValue;

final readonly class AttributeValueHydrator
{
    public function hydrate(AttributeValueData $data, AttributeValue $attributeValue): AttributeValue
    {
        $attributeValue->setValue($data->value);
        $attributeValue->setAttribute($data->attribute);

        return $attributeValue;
    }
}
