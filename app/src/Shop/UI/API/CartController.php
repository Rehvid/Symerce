<?php

declare(strict_types=1);

namespace App\Shop\UI\API;

use App\Admin\Infrastructure\Repository\CartDoctrineRepository;
use App\DTO\Shop\Request\Cart\ChangeQuantityProductRequest;
use App\DTO\Shop\Request\Cart\SaveCartRequest;
use App\DTO\Shop\Response\Cart\CartSaveResponseDTO;
use App\Entity\CartItem;
use App\Enums\CookieName;
use App\Service\Cart\CartService;
use App\Service\CookieManager;
use App\Service\RequestDtoResolver;
use App\Service\Response\ApiResponse;
use App\Service\Response\ResponseService;
use App\Shop\Application\UseCase\Cart\ChangeProductQuantityUseCase;
use App\Shop\Application\UseCase\Cart\CreateCartUseCase;
use App\Shop\Application\UseCase\Cart\ListCartUseCase;
use App\Shop\Application\UseCase\Cart\RemoveCartItemUseCase;
use App\Shop\Application\UseCase\Cart\UpdateCartUseCase;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly RequestDtoResolver     $requestDtoResolver,
        private readonly CookieManager          $cookieManager,
        private readonly ResponseService        $responseService,
        private readonly CartDoctrineRepository $cartRepository,
        private readonly CreateCartUseCase      $createCartUseCase,
        private readonly UpdateCartUseCase      $updateCartUseCase,
        private readonly ParameterBagInterface  $parameterBag,
    )
    {
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, ListCartUseCase $listUseCase): JsonResponse
    {
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        if (!$cart) {
            throw new BadRequestHttpException();
        }

        return $this->responseService->createJsonResponse(
            new ApiResponse([$listUseCase->execute($cart)]),
        );
    }

    #[Route('/change-quantity/', name: 'change-quantity', methods: ['PUT'])]
    public function changeQuantityProduct(
        Request $request,
        ChangeProductQuantityUseCase $useCase
    ): JsonResponse
    {
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));

        if (!$cart) {
            throw new BadRequestHttpException();
        }

        $dto = $this->requestDtoResolver->mapAndValidate($request, ChangeQuantityProductRequest::class);

        return $this->responseService->createJsonResponse(new ApiResponse([$useCase->execute($cart, $dto)]));
    }

    #[Route('/{id}', name: 'remove_item', methods: ['DELETE'])]
    public function removeItem(
        #[MapEntity(mapping: ['id' => 'id'])] CartItem $cartItem,
        Request $request,
        RemoveCartItemUseCase $useCase
    ): JsonResponse {
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        if (!$cart) {
            throw new BadRequestHttpException();
        }

        return $this->responseService->createJsonResponse(new ApiResponse([$useCase->execute($cart, $cartItem)]));
    }


    #[Route('', name: 'add_or_update_cart', methods: ['POST'])]
    public function addOrUpdateCart(Request $request): JsonResponse
    {
        $cartRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCartRequest::class);
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));

        if ($cart) {
            $data = $this->updateCartUseCase->execute($cartRequest, $cart);
            return $this->responseService->createJsonResponse(new ApiResponse(['cart' => $data]));
        }

        $newCart = $this->createCartUseCase->execute($cartRequest);
        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval('PT' . $this->parameterBag->get('app.cart_token_expires'). 'S'));
        $cookie = $this->cookieManager->create(CookieName::SHOP_CART->value, $newCart->getToken(), $expiresAt);

        $response = $this->responseService->createJsonResponse(new ApiResponse([
            'cart' => CartSaveResponseDTO::fromArray([
                'totalQuantity' => $newCart->getTotalQuantity(),
            ])
        ]));

        $response->headers->setCookie($cookie);
        return $response;
    }
}
