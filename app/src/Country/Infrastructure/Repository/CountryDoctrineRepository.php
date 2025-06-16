<?php

declare(strict_types=1);

namespace App\Country\Infrastructure\Repository;

use App\Common\Domain\Entity\Country;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Country\Domain\Repository\CountryRepositoryInterface;

/**
 * @extends AbstractCriteriaRepository<Country>
 */
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
