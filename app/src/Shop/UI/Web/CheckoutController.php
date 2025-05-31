<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Order\Domain\Enums\CheckoutStep;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class CheckoutController extends AbstractController
{

    #[Route('/checkout/{step}', name: 'shop.checkout_step', requirements: ['step' => 'address|shipping|payment|confirmation'], methods: ['GET'])]
    public function renderStep(CheckoutStep $step): Response
    {
        //TODO: Check if customer accomplished previous step and can view next step
        return $this->render('shop/checkout/checkout.html.twig', [
            'step' => $step,
        ]);
    }

    #[Route('/thank-you', name: 'shop.checkout_thank_you', methods: ['GET'])]
    public function thankYou(Request $request): Response
    {
        return $this->render('shop/checkout/thank-you.html.twig');
    }

}
