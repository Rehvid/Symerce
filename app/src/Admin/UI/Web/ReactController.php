<?php

declare(strict_types=1);

namespace App\Admin\UI\Web;

use App\Admin\Application\UseCase\React\ListReactUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReactController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[Route('/admin/{reactRoute}', name: 'app_admin_react', requirements: ['reactRoute' => '.*'])]
    public function list(ListReactUseCase $useCase): Response
    {
        return $this->render('admin/admin.html.twig', $useCase->execute());
    }
}
