<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Repository\Base\AbstractRepository;

class CurrencyRepository extends AbstractRepository
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
