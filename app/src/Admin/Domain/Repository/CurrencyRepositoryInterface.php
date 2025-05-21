<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CurrencyRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface
{

}
