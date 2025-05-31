<?php

declare(strict_types=1);

namespace App\Tag\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Admin\Domain\Repository\ReorderableRepositoryInterface;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface TagRepositoryInterface
    extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, ReorderableRepositoryInterface
{

}
