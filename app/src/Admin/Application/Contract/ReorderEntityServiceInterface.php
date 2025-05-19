<?php

declare(strict_types=1);

namespace App\Admin\Application\Contract;

use App\Admin\Application\DTO\Request\PositionChangeRequest;

interface ReorderEntityServiceInterface
{
    public function reorderEntityPositions(PositionChangeRequest $request, string $entityName): void;
}
