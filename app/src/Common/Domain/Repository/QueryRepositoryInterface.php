<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

interface QueryRepositoryInterface
{
    /** @return object[] */
    public function findAll(): array;

    public function findById(string|int|null $id): ?object;

    /** @return object[] */
    public function findBy(array $criteria, array $sortCriteria = []): array;

    public function getCount(): int;
}
