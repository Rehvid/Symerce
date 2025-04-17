<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Attribute;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class AttributeCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveAttributeRequestDTO::class];
    }
}
