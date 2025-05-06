<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Attribute;

use App\DTO\Admin\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Service\DataPersister\Base\UpdatePersister;

final class AttributeUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [Attribute::class, SaveAttributeRequestDTO::class];
    }
}
