<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('', name: 'shop.home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('shop/home/index.html.twig');
    }
}
