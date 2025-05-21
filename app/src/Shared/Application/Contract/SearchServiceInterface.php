<?php

declare(strict_types=1);

namespace App\Shared\Application\Contract;

use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\DTO\Pagination\PaginationResult;

interface SearchServiceInterface
{
    /**
     * @param SearchCriteria $criteria
     */
    public function search(SearchCriteria $criteria): PaginationResult;
}
