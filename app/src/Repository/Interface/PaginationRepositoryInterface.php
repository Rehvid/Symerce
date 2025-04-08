<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Service\Pagination\PaginationMeta;

interface PaginationRepositoryInterface
{
    /**
     * @param array<string, mixed> $queryParams
     *
     * @return array<int, mixed>
     */
    public function findPaginated(PaginationMeta $paginationMeta, array $queryParams = []): array;
}
