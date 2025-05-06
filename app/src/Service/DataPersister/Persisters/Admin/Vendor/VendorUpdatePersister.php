<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Vendor;

use App\DTO\Admin\Request\Vendor\SaveVendorRequestDTO;
use App\Entity\Vendor;
use App\Service\DataPersister\Base\UpdatePersister;

final class VendorUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [Vendor::class, SaveVendorRequestDTO::class];
    }
}
