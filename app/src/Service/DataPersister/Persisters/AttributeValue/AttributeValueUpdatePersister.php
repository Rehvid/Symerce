<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\AttributeValue;

use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Entity\AttributeValue;
use App\Service\DataPersister\Base\UpdatePersister;

final class AttributeValueUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [AttributeValue::class, SaveAttributeValueRequestDTO::class];
    }
}
