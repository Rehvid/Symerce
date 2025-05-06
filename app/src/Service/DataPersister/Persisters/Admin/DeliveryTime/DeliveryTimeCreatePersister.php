<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\DeliveryTime;

use App\DTO\Admin\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class DeliveryTimeCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveDeliveryTimeRequestDTO::class];
    }
}
