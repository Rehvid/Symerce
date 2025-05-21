<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\DTO\Pagination\PaginationResult;

interface CriteriaRepositoryInterface
{
    public function findByCriteria(SearchCriteria $criteria): PaginationResult;
}
