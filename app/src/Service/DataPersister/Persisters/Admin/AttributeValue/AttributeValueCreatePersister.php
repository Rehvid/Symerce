<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\AttributeValue;

use App\DTO\Admin\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class AttributeValueCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveAttributeValueRequestDTO::class];
    }
}
