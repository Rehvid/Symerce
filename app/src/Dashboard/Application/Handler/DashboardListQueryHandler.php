<?php

declare(strict_types=1);

namespace App\Dashboard\Application\Handler;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Dashboard\Application\Query\GetDashboardListQuery;
use App\Dashboard\Assembler\DashboardAssembler;

final readonly class DashboardListQueryHandler implements QueryHandlerInterface
{
    public function __construct(private DashboardAssembler $dashboardAssembler)
    {
    }

    public function __invoke(GetDashboardListQuery $query): ApiResponse
    {
        return new ApiResponse(data: [
            'data' => $this->dashboardAssembler->toListResponse(),
        ]);
    }
}
