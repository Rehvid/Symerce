<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Carrier;

use App\DTO\Admin\Request\Carrier\SaveCarrierRequestDTO;
use App\Entity\Carrier;
use App\Service\DataPersister\Base\UpdatePersister;

final class CarrierUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [Carrier::class, SaveCarrierRequestDTO::class];
    }
}
