<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\DeliveryTime;

use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Entity\DeliveryTime;
use App\Service\DataPersister\Base\UpdatePersister;

final class DeliveryTimeUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [DeliveryTime::class, SaveDeliveryTimeRequestDTO::class];
    }
}
