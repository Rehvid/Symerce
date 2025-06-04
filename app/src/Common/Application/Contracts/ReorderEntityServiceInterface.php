<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

use App\Common\Application\Dto\Request\PositionChangeRequest;

interface ReorderEntityServiceInterface
{
    public function reorderEntityPositions(PositionChangeRequest $request, string $entityName): void;
}
