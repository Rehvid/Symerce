<?php

declare(strict_types=1);

namespace App\Currency\Infrastructure\Repository;

use App\Common\Domain\Entity\Currency;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

final class CurrencyDoctrineRepository extends AbstractCriteriaRepository implements CurrencyRepositoryInterface
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
