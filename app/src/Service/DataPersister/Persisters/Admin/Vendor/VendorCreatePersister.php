<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Vendor;

use App\DTO\Admin\Request\Vendor\SaveVendorRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class VendorCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveVendorRequestDTO::class];
    }
}
