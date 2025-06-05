<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

use App\Common\Application\Dto\Pagination\PaginationResult;
use App\Common\Application\Search\Dto\SearchCriteria;

interface SearchServiceInterface
{
    /**
     * @param SearchCriteria $criteria
     */
    public function search(SearchCriteria $criteria): PaginationResult;
}
