<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Common\Domain\Entity\Vendor;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class VendorDoctrineRepository extends AbstractCriteriaRepository implements VendorRepositoryInterface
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
