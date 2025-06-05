<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Application\Dto\Pagination\PaginationResult;
use App\Common\Application\Search\Dto\SearchCriteria;

interface CriteriaRepositoryInterface
{
    public function findByCriteria(SearchCriteria $criteria): PaginationResult;
}
