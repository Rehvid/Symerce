<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface ReorderableRepositoryInterface
{
    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array;

    public function getMaxOrder(): int;
}
