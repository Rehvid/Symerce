<?php

declare (strict_types=1);

namespace App\Service\DataPersister\Filler\Shop;

use App\DTO\Admin\Request\PersistableInterface;
use App\DTO\Shop\Request\Cart\SaveCartDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Enums\QuantityChangeType;
use App\Exceptions\PersisterException;
use App\Service\Cart\CartTokenGenerator;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use Doctrine\ORM\EntityManagerInterface;


final class CartEntityFiller extends BaseEntityFiller
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CartTokenGenerator $cartTokenGenerator,
    )
    {
    }

    public function toNewEntity(PersistableInterface|SaveCartDTO $persistable): Cart
    {
        $cart = new Cart();
        $cart->setCartToken($this->cartTokenGenerator->generate());

        return $this->fillEntity($persistable, $cart);
    }

    /**
     * @param Cart $entity
     */
    public function toExistingEntity(PersistableInterface|SaveCartDTO $persistable, object $entity): Cart
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveCartDTO::class;
    }

    /**
     * @param Cart $entity
     */
    protected function fillEntity(PersistableInterface|SaveCartDTO $persistable, object $entity): Cart
    {
        $product = $this->findProduct($persistable->productId);

        $cartItem = $entity->getItems()->filter(
            fn (CartItem $cartItem) => $cartItem->getProduct()->getId() === $persistable->productId
        )->first();

        return $cartItem
            ? $this->updateCartItem($persistable, $entity, $product, $cartItem)
            : $this->addCartItem($persistable, $entity, $product);
    }

    private function addCartItem(PersistableInterface|SaveCartDTO $persistable, Cart $cart, Product $product): Cart
    {
        $price = $product->getDiscountPrice() ?? $product->getRegularPrice();

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity($persistable->quantity);
        $cartItem->setPrice($price);
        $cartItem->setCart($cart);

        $cart->addItem($cartItem);

        return $cart;
    }

    private function updateCartItem(
        PersistableInterface|SaveCartDTO $persistable,
        Cart $cart,
        Product $product,
        CartItem $cartItem
    ): Cart {
        $price = $product->getDiscountPrice() ?? $product->getRegularPrice();

        if ($persistable->method === QuantityChangeType::Increase) {
            $quantityBeforeIncrease = $cartItem->getQuantity() + $persistable->quantity;
            if ($product->getQuantity() <= $quantityBeforeIncrease) {
                throw new PersisterException('Cannot increase over product total quantity.');
            }

            $cartItem->setQuantity($cartItem->getQuantity() + $persistable->quantity);
        } elseif ($persistable->method === QuantityChangeType::Decrease) {
            $quantityBeforeRemove = $cartItem->getQuantity() - $persistable->quantity;
            if ($quantityBeforeRemove <= 0) {
                throw new PersisterException('Cannot decrease below zero');
            }

            $cartItem->setQuantity($cartItem->getQuantity() - $persistable->quantity);
        }

        if ($cartItem->getPrice() !== $price) {
            $cartItem->setPrice($price);
        }

        return $cart;
    }

    private function findProduct(int $productId): Product
    {
        return $this->entityManager->getRepository(Product::class)->find($productId);
    }
}
