<?php

declare(strict_types=1);

namespace App\Cart\Application\Factory;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\ValueObject\DateVO;
use App\Cart\Application\Dto\Response\CartDetailItemResponse;
use App\Cart\Application\Dto\Response\CartDetailResponse;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailItemResponse;
use App\Shared\Application\Factory\MoneyFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CartDetailResponseFactory
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
    ) {}

    public function fromCart(Cart $cart): CartDetailResponse
    {
        return new CartDetailResponse(
            id: $cart->getId(),
            createdAt: (new DateVO($cart->getCreatedAt()))->formatRaw(),
            updatedAt: (new DateVO($cart->getUpdatedAt()))->formatRaw(),
            expiresAt: (new DateVO($cart->getExpiresAt()))->formatRaw(),
            customer: $cart?->getCustomer()?->getContactDetails()?->getFullName(),
            items: array_map(
                fn (CartItem $cartItem) => $this->createCartDetailItemResponse($cartItem),
                $cart->getItems()->toArray()
            ),
        );
    }


    //TODO: It's duplicated from orderResponse, create one DTO instaed of two
    private function createCartDetailItemResponse(CartItem $cartItem): CartDetailItemResponse
    {
        $product = $cartItem->getProduct();
        $unitPrice = $this->moneyFactory->create($cartItem->getPrice());
        $editUrl = null;
        $imageUrl = null;

        if ($product) {
            $editUrl = $this->urlGenerator->generate(
                'app_admin_react',
                [
                    'reactRoute' => "products/{$product->getId()}/edit"
                ]
            );
            $imageUrl = $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile());
        }


        return new CartDetailItemResponse(
            name: $product?->getName(),
            imageUrl: $imageUrl ?? null,
            unitPrice: $unitPrice->getFormattedAmountWithSymbol(),
            quantity: $cartItem->getQuantity(),
            totalPrice: $unitPrice->multiply($cartItem->getQuantity())->getFormattedAmountWithSymbol(),
            editUrl: $editUrl ?? null,
        );
    }
}
