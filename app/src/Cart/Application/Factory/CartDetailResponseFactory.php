<?php

declare(strict_types=1);

namespace App\Cart\Application\Factory;

use App\Cart\Application\Dto\Response\CartDetailItemResponse;
use App\Cart\Application\Dto\Response\CartDetailResponse;
use App\Common\Application\Dto\Response\OrderableItemResponse;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\Common\Domain\ValueObject\DateVO;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CartDetailResponseFactory
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
    ) {
    }

    public function fromCart(Cart $cart): CartDetailResponse
    {
        return new CartDetailResponse(
            id: $cart->getId(),
            createdAt: (new DateVO($cart->getCreatedAt()))->formatRaw(),
            updatedAt: (new DateVO($cart->getUpdatedAt()))->formatRaw(),
            expiresAt: (new DateVO($cart->getExpiresAt()))->formatRaw(),
            customer: $cart?->getCustomer()?->getContactDetails()?->getFullName(),
            items: array_map(
                fn (CartItem $cartItem) => $this->createOrderableItemResponse($cartItem),
                $cart->getItems()->toArray()
            ),
        );
    }

    private function createOrderableItemResponse(CartItem $cartItem): OrderableItemResponse
    {
        $product = $cartItem->getProduct();
        $unitPrice = $this->moneyFactory->create($cartItem->getPrice());
        $editUrl = null;
        $imageUrl = null;

        if ($product) {
            $editUrl = $this->urlGenerator->generate(
                'app_admin_react',
                [
                    'reactRoute' => "products/{$product->getId()}/edit",
                ]
            );
            $imageUrl = $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile());
        }


        return new OrderableItemResponse(
            name: $product?->getName(),
            imageUrl: $imageUrl ?? null,
            unitPrice: $unitPrice->getFormattedAmountWithSymbol(),
            quantity: $cartItem->getQuantity(),
            totalPrice: $unitPrice->multiply($cartItem->getQuantity())->getFormattedAmountWithSymbol(),
            editUrl: $editUrl ?? null,
        );
    }
}
