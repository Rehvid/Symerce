<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface OrderSortableRepositoryInterface
{
    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array;
}
