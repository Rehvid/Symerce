<?php

declare(strict_types=1);

namespace App\Currency\Domain\Repository;

use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Currency>
 */
interface CurrencyRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface
{
}
