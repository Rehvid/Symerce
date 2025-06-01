<?php

namespace App\Shop\Application\Assembler;

use App\Admin\Application\Service\FileService;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Shared\Application\Service\SettingsService;
use App\Shop\Application\DTO\Response\Cart\CartItemResponse;
use App\Shop\Application\DTO\Response\Cart\CartResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CartAssembler
{
     public function __construct(
         private SettingsService $settingManager,
         private UrlGeneratorInterface $urlGenerator,
         private FileService $fileService
     ) {
     }

    public function transformCartItemToOrderItem(Order $order, CartItem $cartItem): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($cartItem->getProduct());
        $orderItem->setQuantity($cartItem->getQuantity());
        $orderItem->setUnitPrice($cartItem->getPrice());
        $orderItem->setOrder($order);

        return $orderItem;
    }

    public function calculateTotalPrice(Cart $cart): string
    {
        $currency = $this->settingManager->findDefaultCurrency();
        $precision = $currency->getRoundingPrecision();
        $total = '0.00';

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item) {
            $price = $item->getPrice();
            $quantity = (string) $item->getQuantity();

            $itemTotal = bcmul($price, $quantity, $precision);
            $total = bcadd($total, $itemTotal, $precision);
        }

        return $total;
    }

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
