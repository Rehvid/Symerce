<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface BaseRepositoryInterface
{
    public function findPaginated(array $queryParams);
}
