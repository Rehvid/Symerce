<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[Route('/admin/{reactRoute}', name: 'app_admin_react', requirements: ['reactRoute' => '.*'])]
    public function index(): Response
    {
        return $this->render('admin.html.twig');
    }
}
