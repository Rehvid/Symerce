<?php

declare(strict_types=1);

namespace App\Tag\Domain\Repository;

use App\Common\Domain\Entity\Tag;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Tag>
 */
interface TagRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
}
