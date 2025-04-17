<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\DeliveryTime;

use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class DeliveryTimeCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveDeliveryTimeRequestDTO::class];
    }
}
