<?php

declare(strict_types=1);

namespace App\Mapper\Shop;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Service\FileService;
use App\Shop\Application\DTO\Response\Cart\CartItemResponse;
use App\Shop\Application\DTO\Response\Cart\CartResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/** @deprecated */
final class CartMapper
{
    public function __construct(
        private readonly FileService $fileService,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {}

    public function mapCartToResponse(Cart $cart): CartResponse
    {
        $cartItemResponses = array_map(
            fn(CartItem $item) => $this->mapCartItemToResponse($item),
            $cart->getItems()->toArray()
        );

        return new CartResponse(
            id: $cart->getId(),
            cartItems: $cartItemResponses,
        );
    }

    public function mapCartItemToResponse(CartItem $cartItem): CartItemResponse
    {
        $product = $cartItem->getProduct();
        return new CartItemResponse(
            id: $cartItem->getId(),
            quantity: $cartItem->getQuantity(),
            price: $cartItem->getPrice(),
            productId: $product->getId(),
            productName: $product->getName(),
            productUrl: $this->urlGenerator->generate(
                'shop.product_show',
                [
                    'slug' => $product->getSlug(),
                    'slugCategory' => $product->getCategories()->first()->getSlug()
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            productImage: $this->fileService->preparePublicPathToFile(
                $product->getThumbnailImage()?->getFile()?->getPath()
            ),
        );
    }
}
