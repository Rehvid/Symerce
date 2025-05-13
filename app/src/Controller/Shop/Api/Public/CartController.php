<?php

declare(strict_types=1);

namespace App\Controller\Shop\Api\Public;

use App\DTO\Shop\Request\Cart\SaveCartDTO;
use App\Enums\CookieName;
use App\Repository\CartRepository;
use App\Service\Cart\CartService;
use App\Service\CookieManager;
use App\Service\RequestDtoResolver;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    public function __construct(
        protected readonly RequestDtoResolver $requestDtoResolver,
        protected readonly CartService        $cartService,
        private readonly ResponseService      $responseService,
        private readonly CookieManager        $cookieManager,
        private readonly CartRepository       $cartRepository,
    )
    {
    }


    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(Request $request): JsonResponse
    {
        $dto = $this->requestDtoResolver->mapAndValidate($request, SaveCartDTO::class);

        $data = $this->cartService->handleAddToCart($dto);

        $response = $this->responseService->createJsonResponse(new ApiResponse(['cart' => $data]));

        if (!$this->cookieManager->exists(CookieName::SHOP_CART->value)) {
            $time = ( new \DateTime())->modify('+1 month')->getTimestamp();
            $response->headers->setCookie($this->cookieManager->create(CookieName::SHOP_CART->value, $data->token, $time));
        }

        return $response;
    }

    #[Route('/increase-decrease', name: 'increase_decrease', methods: ['PUT'])]
    public function increaseOrDecrease(Request $request): JsonResponse
    {
        $dto = $this->requestDtoResolver->mapAndValidate($request, SaveCartDTO::class);

        $data = $this->cartService->increaseOrDecrease($dto);

        return $this->responseService->createJsonResponse(new ApiResponse(['cart' => $data]));
    }

    #[Route('/{productId}', name: 'remove_item_cart', methods: ['DELETE'])]
    public function removeFromCart(string $productId, Request $request): JsonResponse
    {
        $cookie = $request->cookies->get(CookieName::SHOP_CART->value);
        if (!$cookie) {
            throw new BadRequestHttpException();
        }

        $cart = $this->cartRepository->findOneBy(['cartToken' => $cookie]);
        if (!$cart) {
            throw new BadRequestHttpException();
        }

        $this->cartService->handleRemoveItemFromCart($productId, $cart);

        return new JsonResponse();
    }
}
