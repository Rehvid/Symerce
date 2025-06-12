<?php

declare(strict_types=1);

namespace App\Dashboard\Ui\Api\Controller;

use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Dashboard\Application\Query\GetDashboardListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/api/admin/dashboard', name: 'api_admin_dashboard_list', methods: ['GET'])]
    public function list(QueryBusInterface $queryBus): JsonResponse
    {
        return $this->json(
            data: $queryBus->ask(
                new GetDashboardListQuery()
            )
        );
    }
}
