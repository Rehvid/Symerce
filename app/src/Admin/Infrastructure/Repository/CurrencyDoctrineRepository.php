<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Entity\Currency;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CurrencyDoctrineRepository extends AbstractCriteriaRepository implements CurrencyRepositoryInterface
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
