<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vendor;
use App\Repository\Base\AbstractRepository;

class VendorRepository extends AbstractRepository
{
    protected function getEntityClass(): string
    {
        return Vendor::class;
    }

    protected function getAlias(): string
    {
        return 'vendor';
    }
}
