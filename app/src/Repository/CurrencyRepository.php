<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Repository\Base\PaginationRepository;

class CurrencyRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Currency::class;
    }

    protected function getAlias(): string
    {
        return 'currency';
    }
}
