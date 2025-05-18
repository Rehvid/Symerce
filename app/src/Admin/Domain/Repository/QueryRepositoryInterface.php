<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface QueryRepositoryInterface
{
    /** @return object[] */
    public function findAll(): array;

    public function findById(string|int $id): ?object;

    /** @return object[] */
    public function findBy(array $criteria): array;
}
