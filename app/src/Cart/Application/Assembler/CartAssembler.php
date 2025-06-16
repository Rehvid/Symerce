<?php

namespace App\Cart\Application\Assembler;

use App\Cart\Application\Dto\Response\CartListResponse;
use App\Cart\Application\Factory\CartDetailResponseFactory;
use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Application\Service\FileService;
use App\Common\Application\Service\SettingsService;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\ValueObject\DateVO;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shop\Application\DTO\Response\Cart\CartItemResponse;
use App\Shop\Application\DTO\Response\Cart\CartResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CartAssembler
{
    public function __construct(
        private SettingsService $settingManager,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
        private ResponseHelperAssembler $responseHelperAssembler,
        private OrderRepositoryInterface $orderRepository,
        private CartDetailResponseFactory $cartDetailResponseFactory,
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        return $this->responseHelperAssembler->wrapListWithAdditionalData(
            dataList: array_map(fn (Cart $cart) => $this->createCartListResponse($cart), $paginatedData)
        );
    }

    private function createCartListResponse(Cart $cart): CartListResponse
    {
        /** @var ?Order $order */
        $order = $this->orderRepository->findByToken($cart->getToken());
        $customer = null;

        if (null !== $cart->getCustomer()) {
            $customer = $cart->getCustomer()->getContactDetails()?->getFullName();
        }

        return new CartListResponse(
            id: $cart->getId(),
            orderId: $order?->getId(),
            customer: $customer,
            total: $this->calculateTotalPrice($cart),
            expiresAt: (new DateVO($cart->getExpiresAt()))->formatRaw(),
            createdAt: (new DateVO($cart->getCreatedAt()))->formatRaw(),
            updatedAt: (new DateVO($cart->getUpdatedAt()))->formatRaw(),
        );
    }

    public function toDetailResponse(Cart $cart): array
    {
        return [
            'data' => $this->cartDetailResponseFactory->fromCart($cart),
        ];
    }

    /* @deprecated */
    public function transformCartItemToOrderItem(Order $order, CartItem $cartItem): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($cartItem->getProduct());
        $orderItem->setQuantity($cartItem->getQuantity());
        $orderItem->setUnitPrice($cartItem->getPrice());
        $orderItem->setOrder($order);

        return $orderItem;
    }

    /* @deprecated */
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

    /* @deprecated */
    public function mapCartToResponse(Cart $cart): CartResponse
    {
        $cartItemResponses = array_map(
            fn (CartItem $item) => $this->mapCartItemToResponse($item),
            $cart->getItems()->toArray()
        );

        return new CartResponse(
            id: $cart->getId(),
            cartItems: $cartItemResponses,
        );
    }

    /* @deprecated */
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
                    'slugCategory' => $product->getCategories()->first()->getSlug(),
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            productImage: $this->fileService->preparePublicPathToFile(
                $product->getThumbnailImage()?->getFile()?->getPath()
            ),
        );
    }
}
