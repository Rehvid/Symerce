<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Carrier;

use App\DTO\Admin\Request\Carrier\SaveCarrierRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class CarrierCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveCarrierRequestDTO::class];
    }
}
