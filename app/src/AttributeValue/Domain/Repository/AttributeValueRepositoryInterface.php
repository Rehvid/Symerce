<?php

declare(strict_types=1);

namespace App\AttributeValue\Domain\Repository;

use App\Admin\Domain\Repository\PositionRepositoryInterface;
use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface AttributeValueRepositoryInterface
    extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{

}
