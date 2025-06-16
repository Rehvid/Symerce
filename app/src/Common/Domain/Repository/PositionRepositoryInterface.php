<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Contracts\PositionEntityInterface;

interface PositionRepositoryInterface
{
    /** @return array<int, mixed> */
    public function findItemsInOrderRange(int $oldOrder, int $newOrder): array;

    public function getMaxPosition(): int;

    public function findByMovedId(int $movedId): ?PositionEntityInterface;
}
