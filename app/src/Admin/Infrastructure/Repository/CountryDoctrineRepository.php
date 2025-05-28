<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Country\Domain\Repository\CountryRepositoryInterface;
use App\Admin\Domain\Entity\Country;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CountryDoctrineRepository extends AbstractCriteriaRepository implements CountryRepositoryInterface
{

    protected function getAlias(): string
    {
        return 'country';
    }

    protected function getEntityClass(): string
    {
        return Country::class;
    }
}
