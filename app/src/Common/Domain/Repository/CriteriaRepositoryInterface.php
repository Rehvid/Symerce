<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Dto\Pagination\PaginationResult;

interface CriteriaRepositoryInterface
{
    public function findByCriteria(SearchCriteria $criteria): PaginationResult;
}
