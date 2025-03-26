<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Service\Pagination\PaginationMeta;

interface BaseRepositoryInterface
{
    public function findPaginated(PaginationMeta $paginationMeta, array $queryParams = []);
}
