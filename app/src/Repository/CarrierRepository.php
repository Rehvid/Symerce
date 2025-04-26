<?php

namespace App\Repository;

use App\Entity\Carrier;
use App\Repository\Base\AbstractRepository;

class CarrierRepository extends AbstractRepository
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
