<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Admin\Infrastructure\Repository\CartDoctrineRepository;
use App\Enums\CheckoutStep;
use App\Enums\CookieName;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CheckoutController extends AbstractController
{
    public function __construct(
        private readonly CartDoctrineRepository $cartRepository,
        private readonly OrderRepository        $orderRepository,
    ) {
    }

    #[Route('/checkout/{step}', name: 'shop.checkout_step', requirements: ['step' => 'address|shipping|payment|confirmation'], methods: ['GET'])]
    public function renderStep(Request $request, CheckoutStep $step): Response
    {
        if ($step === CheckoutStep::ADDRESS) {
            $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
            if (!$cart) {
                throw $this->createNotFoundException();
            }
        } else {
            $this->ensureOrderExists($request);
        }



        return $this->render('shop/checkout/checkout.html.twig', [
            'step' => $step,
        ]);
    }

    #[Route('/thank-you', name: 'shop.checkout_thank_you', methods: ['GET'])]

    public function thankYou(Request $request): Response
    {
        $this->ensureOrderExists($request);

        return $this->render('shop/checkout/thank-you.html.twig');
    }

    private function ensureOrderExists(Request $request): void
    {
        $order = $this->orderRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        if (null === $order) {
            throw $this->createNotFoundException();
        }
    }
}
