<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

/**
 * @template T of object
 */
interface QueryRepositoryInterface
{
    /** @return T[] */
    public function findAll(): array;

    /** @return T|null */
    public function findById(string|int|null $id): ?object;

    /** @return T[] */
    public function findBy(array $criteria, array $sortCriteria = []): array;

    public function getCount(): int;
}
