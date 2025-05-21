<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Shop\Application\UseCase\Cart\Web\GetByCookieCartUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/koszyk', name: 'shop.cart', methods: ['GET'])]
    public function index(Request $request, GetByCookieCartUseCase $useCase): Response
    {
        return $this->render('shop/cart/index.html.twig', $useCase->execute($request));
    }
}
