<?php

declare(strict_types=1);

namespace App\Shop\Application\Service;

use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\Common\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductDoctrineRepository;
use App\Shared\Infrastructure\Repository\CartDoctrineRepository;
use App\Shared\Infrastructure\Service\CartTokenGenerator;
use App\Shop\Application\DTO\Request\Cart\ChangeQuantityProductRequest;
use App\Shop\Application\DTO\Request\Cart\SaveCartRequest;
use App\Shop\Domain\Enums\QuantityChangeType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


//TODO: Refactor
final readonly class CartService
{
   public function __construct(
       private readonly CartDoctrineRepository    $repository,
       private readonly ProductDoctrineRepository $productRepository,
       private readonly CartTokenGenerator        $cartTokenGenerator,
       private readonly ParameterBagInterface     $parameterBag,
   )
   {}

    public function changeQuantityCartItem(ChangeQuantityProductRequest $request, Cart $cart): int
    {
        $product = $this->findProductById($request->productId);
        if (!$product) {
            throw new \LogicException('Product not found');
        }

        $cartItem = $cart->getCartItemByProductId($product->getId());
        if (!$cartItem) {
            throw new \LogicException('Cart item does not exist');
        }

        $modifier = $request->newQuantity - $cartItem->getQuantity();


        $this->modifyCartItemQuantity($cartItem, $product, $modifier);
        $this->repository->save($cart);

        return $modifier;
    }

    public function modifyCartItemQuantity(
        CartItem $cartItem,
        Product $product,
        int $modifier,
        ?QuantityChangeType $changeType = null
    ): void {
        if ($modifier === 0) {
            return;
        }

        $changeType ??= $modifier > 0
            ? QuantityChangeType::Increase
            : QuantityChangeType::Decrease;

        if ($changeType === QuantityChangeType::Increase) {
            $this->increaseCartItemQuantity($cartItem, $product, abs($modifier));
        } else {
            $this->decreaseCartItemQuantity($cartItem, abs($modifier));
        }
    }

    private function increaseCartItemQuantity(CartItem $cartItem, Product $product, int $amount): void
    {
        $newQuantity = $cartItem->getQuantity() + $amount;

        if ($newQuantity > $product->getQuantity()) {
            throw new \LogicException(sprintf(
                'Cannot increase quantity beyond available product stock (%d).',
                $product->getQuantity()
            ));
        }

        $cartItem->setQuantity($newQuantity);
    }

    private function decreaseCartItemQuantity(CartItem $cartItem, int $amount): void
    {
        $newQuantity = $cartItem->getQuantity() - $amount;

        if ($newQuantity <= 0) {
            throw new \LogicException('Cannot decrease quantity to zero or less.');
        }

        $cartItem->setQuantity($newQuantity);
    }

    public function create(SaveCartRequest $request): Cart
    {
        $cart = new Cart();
        $cart->setToken($this->cartTokenGenerator->generate());

        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval('PT' . $this->parameterBag->get('app.cart_token_expires'). 'S'));
        $cart->setExpiresAt($expiresAt);

        $this->setCommonFields($request, $cart);
        $this->repository->save($cart);

        return $cart;
    }

    public function update(SaveCartRequest $request, Cart $cart): Cart
    {
        $this->setCommonFields($request, $cart);
        $this->repository->save($cart);

        return $cart;
    }

    public function deleteItem(Cart $cart, CartItem $cartItem): Cart
    {
        $cart->removeItem($cartItem);
        $this->repository->save($cart);

        return $cart;
    }

    private function setCommonFields(SaveCartRequest $request, Cart $cart): void
    {
        $product = $this->findProductById((int) $request->productId);
        if ($product === null) {
            throw new \LogicException(sprintf('Cannot find product with id %d', $request->productId));
        }

        $cartItem = $cart->getItems()->filter(
            fn (CartItem $cartItem) => $cartItem->getProduct()->getId() === $product->getId() ?? false
        )->first();

        if (!$cartItem)  {
            $this->addCartItem($request, $product, $cart);
        } else {
            $this->updateCartItem($request, $product, $cartItem);
        }
    }

    private function addCartItem(SaveCartRequest $request, Product $product, Cart $cart): void
    {
        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity($request->quantity);
        $cartItem->setPrice($product->getCurrentPrice());
        $cartItem->setCart($cart);

        $cart->addItem($cartItem);
    }

    private function updateCartItem(SaveCartRequest $request, Product $product, CartItem $cartItem): void
    {
        $this->modifyCartItemQuantity($cartItem, $product, $request->quantity);

        if ($cartItem->getPrice() !== $product->getCurrentPrice()) {
            $cartItem->setPrice($product->getCurrentPrice());
        }
    }

    private function findProductById(int $productId): ?Product
    {
        return $this->productRepository->find($productId);
    }
}




