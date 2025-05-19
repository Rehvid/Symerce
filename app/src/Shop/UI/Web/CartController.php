<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Admin\Infrastructure\Repository\CartDoctrineRepository;
use App\Enums\CookieName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class CartController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface    $translator,
        private readonly CartDoctrineRepository $cartRepository,
    ) {
    }

    #[Route('/koszyk', name: 'shop.cart', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $cartCookie = $request->cookies->get(CookieName::SHOP_CART->value);
        if (!$cartCookie) {
            throw $this->createNotFoundException($this->translator->trans('shop.errors.not_found'));
        }

        $cart = $this->cartRepository->findByToken($cartCookie);
        if (!$cart) {
            throw $this->createNotFoundException($this->translator->trans('shop.errors.not_found'));
        }

        return $this->render('shop/cart/index.html.twig', ['cart' => $cart]);
    }
}
