<?php

declare(strict_types=1);

namespace App\Shop\UI\API;

use App\Cart\Infrastructure\Repository\CartDoctrineRepository;
use App\Common\Domain\Entity\CartItem;
use App\Service\CookieManager;
use App\Service\Response\ResponseService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Domain\Enums\CookieName;
use App\Shared\Infrastructure\Http\CookieFactory;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Shop\Application\DTO\Request\Cart\ChangeQuantityProductRequest;
use App\Shop\Application\DTO\Request\Cart\SaveCartRequest;
use App\Shop\Application\DTO\Response\Cart\CartSaveResponse;
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

        return $this->json(
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

        return $this->json(new ApiResponse([$useCase->execute($cart, $dto)]));
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

        return $this->json(new ApiResponse([$useCase->execute($cart, $cartItem)]));
    }


    #[Route('', name: 'add_or_update_cart', methods: ['POST'])]
    public function addOrUpdateCart(Request $request, CookieFactory $cookieFactory): JsonResponse
    {
        $cartRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCartRequest::class);
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));

        if ($cart) {
            $data = $this->updateCartUseCase->execute($cartRequest, $cart);
            return $this->json(new ApiResponse(['cart' => $data]));
        }

        $newCart = $this->createCartUseCase->execute($cartRequest);
        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval('PT' . $this->parameterBag->get('app.cart_token_expires'). 'S'));
        $cookie = $cookieFactory->create(CookieName::SHOP_CART, $newCart->getToken(), $expiresAt);

        $response = $this->json(
            new ApiResponse(
                data: [
                    'cart' => new CartSaveResponse(totalQuantity: $newCart->getTotalQuantity())
                ]
            )
        );

        $response->headers->setCookie($cookie);
        return $response;
    }
}
