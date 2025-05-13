<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\DTO\Shop\Request\Cart\SaveCartDTO;
use App\DTO\Shop\Response\Cart\CartSaveResponseDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Enums\QuantityChangeType;
use App\Repository\CartRepository;
use App\Service\DataPersister\Manager\PersisterManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class CartService
{
    public function __construct(
        private CartRepository   $cartRepository,
        private PersisterManager $persisterManager,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function handleAddToCart(SaveCartDTO $dto): ResponseInterfaceData|CartSaveResponseDTO
    {
        $cart = $this->cartRepository->findOneBy(['cartToken' => $dto->cartToken]);
        if (null === $cart) {
            $cart = $this->persisterManager->persist($dto);
        } else {
            $cart = $this->persisterManager->update($dto, $cart);
        }
        /** @var Cart $cart */

        return CartSaveResponseDTO::fromArray([
            'token' => $cart->getCartToken(),
            'totalQuantity' => $cart->getTotalQuantity(),
        ]);
    }

    public function handleRemoveItemFromCart(string $productId, Cart $cart): void
    {
        $items = $cart->getItems();
        $item = $items->filter(function (CartItem $cartItem) use ($productId) {
            return $cartItem->getProduct()->getId() === (int) $productId;
        })->first();

        $cart->removeItem($item);

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function increaseOrDecrease(SaveCartDTO $dto): ResponseInterfaceData
    {
        $cart = $this->cartRepository->findOneBy(['cartToken' => $dto->cartToken]);
        if (null === $cart) {
            throw new BadRequestHttpException();
        }

        $cartItem = $cart->getItems()->filter(function (CartItem $cartItem) use ($dto) {
            return $cartItem->getProduct()->getId() === $dto->productId;
        })->first();

        if ($dto->method === QuantityChangeType::Increase->value) {
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        } else if ($dto->method === QuantityChangeType::Decrease->value) {

            //TODO: Resolve problem with remove below 0
            $cartItem->setQuantity($cartItem->getQuantity() - 1);
        }

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return CartSaveResponseDTO::fromArray([
            'token' => $cart->getCartToken(),
            'totalQuantity' => $cart->getTotalQuantity(),
        ]);
    }
}
