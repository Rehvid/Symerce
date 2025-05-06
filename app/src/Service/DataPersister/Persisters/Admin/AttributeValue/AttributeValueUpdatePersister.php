<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\AttributeValue;

use App\DTO\Admin\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Entity\AttributeValue;
use App\Service\DataPersister\Base\UpdatePersister;

final class AttributeValueUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [AttributeValue::class, SaveAttributeValueRequestDTO::class];
    }
}
