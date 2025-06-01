<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Reorder;

use App\Admin\Application\Contract\ReorderEntityServiceInterface;
use App\Admin\Application\DTO\Request\PositionChangeRequest;
use App\Admin\Application\Service\PositionEntityService;

final readonly class ReorderPositionsUseCase
{
    public function __construct(
        private ReorderEntityServiceInterface $reorderEntityService,
    ) {
    }

    public function execute(PositionChangeRequest $positionChangeRequest, string $entityClass): void
    {
        $this->reorderEntityService->reorderEntityPositions($positionChangeRequest, $entityClass);
    }
}
