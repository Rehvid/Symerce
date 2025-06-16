<?php

declare(strict_types=1);

namespace App\Country\Domain\Repository;

use App\Common\Domain\Entity\Country;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/** @extends QueryRepositoryInterface<Country> */
interface CountryRepositoryInterface
    extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface
{

}
