<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Dto\Pagination\PaginationResult;

interface SearchServiceInterface
{
    /**
     * @param SearchCriteria $criteria
     */
    public function search(SearchCriteria $criteria): PaginationResult;
}
