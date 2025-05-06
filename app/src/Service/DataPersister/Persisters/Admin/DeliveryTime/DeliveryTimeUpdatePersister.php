<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\DeliveryTime;

use App\DTO\Admin\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Entity\DeliveryTime;
use App\Service\DataPersister\Base\UpdatePersister;

final class DeliveryTimeUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [DeliveryTime::class, SaveDeliveryTimeRequestDTO::class];
    }
}
