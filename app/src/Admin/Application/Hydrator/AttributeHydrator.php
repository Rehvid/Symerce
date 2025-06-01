<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Attribute\SaveAttributeRequest;
use App\Common\Domain\Entity\Attribute;

final readonly class AttributeHydrator
{
    public function hydrate(SaveAttributeRequest $request, Attribute $attribute): Attribute
    {
        $attribute->setName($request->name);

        return $attribute;
    }
}
