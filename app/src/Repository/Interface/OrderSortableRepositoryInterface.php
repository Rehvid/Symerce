<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface OrderSortableRepositoryInterface
{
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array;
}
