<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\ValueObject\Money;

class CartService
{
     public function __construct(
         private readonly SettingManager $settingManager,
     )
     {
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
}
