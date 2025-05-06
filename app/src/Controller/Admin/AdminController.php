<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\DataProvider\ReactDataProvider;
use App\Service\DataProvider\SettingsProvider;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[Route('/admin/{reactRoute}', name: 'app_admin_react', requirements: ['reactRoute' => '.*'])]
    public function index(SettingsProvider $provider, FileService $service): Response
    {
        $reactDataProvider = new ReactDataProvider();
        $reactDataProvider->add($provider);

        return $this->render('admin/admin.html.twig', [
            'data' => $reactDataProvider->getData(),
            'logo' => $service->getLogoPublicPath()
        ]);
    }
}
