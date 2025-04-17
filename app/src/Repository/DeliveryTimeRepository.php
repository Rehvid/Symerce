<?php

namespace App\Repository;

use App\Entity\DeliveryTime;
use App\Repository\Base\PaginationRepository;

class DeliveryTimeRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return DeliveryTime::class;
    }

    protected function getAlias(): string
    {
        return 'delivery_time';
    }
}
