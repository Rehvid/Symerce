<?php

declare(strict_types=1);

namespace App\AdminEntry\Ui\Web\Controller;

use App\AdminEntry\Application\Query\GetAdminEntryListQuery;
use App\Shared\Infrastructure\Bus\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReactController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[Route('/admin/{reactRoute}', name: 'app_admin_react', requirements: ['reactRoute' => '.*'])]
    public function list(QueryBusInterface $queryBus): Response
    {
        return $this->render(
            'admin/admin.html.twig',
            $queryBus->ask(new GetAdminEntryListQuery())
        );
    }
}
