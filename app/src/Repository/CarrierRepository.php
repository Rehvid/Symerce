<?php

namespace App\Repository;

use App\Entity\Carrier;
use App\Repository\Base\PaginationRepository;

class CarrierRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Carrier::class;
    }

    protected function getAlias(): string
    {
        return 'carrier';
    }
}
