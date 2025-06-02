<?php

declare(strict_types=1);

namespace App\Attribute\Application\Hydrator;

use App\Attribute\Application\Dto\AttributeData;
use App\Common\Domain\Entity\Attribute;

final readonly class AttributeHydrator
{
    public function hydrate(AttributeData $data, Attribute $attribute): Attribute
    {
        $attribute->setName($data->name);
        $attribute->setType($data->type);
        $attribute->setActive($data->isActive);

        return $attribute;
    }
}
