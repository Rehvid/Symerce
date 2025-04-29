<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Service\Pagination\PaginationFilters;
use App\Service\Pagination\PaginationMeta;

interface PaginationRepositoryInterface
{
    /**
     * @return array<string, mixed>
     */
    public function findPaginated(PaginationMeta $paginationMeta, PaginationFilters $paginationFilters): array;
}
