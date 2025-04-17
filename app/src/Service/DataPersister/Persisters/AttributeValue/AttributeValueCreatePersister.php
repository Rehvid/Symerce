<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\AttributeValue;

use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class AttributeValueCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveAttributeValueRequestDTO::class];
    }
}
