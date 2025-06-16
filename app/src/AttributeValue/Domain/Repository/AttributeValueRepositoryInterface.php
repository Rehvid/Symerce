<?php

declare(strict_types=1);

namespace App\AttributeValue\Domain\Repository;

use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<AttributeValue>
 */
interface AttributeValueRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
}
