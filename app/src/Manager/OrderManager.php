<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Shop\Request\Checkout\SaveCheckoutAddressRequest;
use App\Entity\Carrier;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Repository\OrderRepository;
use App\Service\CartService;
use App\Shared\Domain\Enums\CheckoutStep;
use App\Shared\Domain\Enums\PaymentStatus;

class OrderManager
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderRepository $orderRepository,
        private readonly AddressManager $addressManager,
        private readonly ContactDetailsManager $contactDetailsManager,
    ) {
    }

    public function createOrder(SaveCheckoutAddressRequest $request, Cart $cart): Order
    {
        $order = new Order();
        $order->setCartToken($cart->getToken());
        $order->setDeliveryAddress($this->addressManager->createDeliveryAddress($request->saveAddressDeliveryRequest));

        if ($request->useInvoiceAddress) {
            $order->setInvoiceAddress($this->addressManager->createInvoiceAddress($request->saveAddressInvoiceRequest));
        }

        if ($cart->getUser()) {
            $order->setCustomer($cart->getUser());
        }

        $cartItems = $cart->getItems();

        /** @var CartItem $cartItem */
        foreach ($cartItems as $cartItem) {
            $order->addOrderItem($this->cartService->transformCartItemToOrderItem($order, $cartItem));
        }

        $order->setTotalPrice($this->cartService->calculateTotalPrice($cart));
        $order->setContactDetails(
            $this->contactDetailsManager->createContactDetails($request->saveContactDetailsRequest)
        );

        $this->orderRepository->save($order);

        return $order;
    }

    public function updateAddresses(SaveCheckoutAddressRequest $request, Order $order): Order
    {
        $order->setContactDetails(
            $this->contactDetailsManager->updateContactDetails(
                $request->saveContactDetailsRequest,
                $order->getContactDetails()
            )
        );

        $order->setDeliveryAddress(
            $this->addressManager->updateDeliveryAddress(
                $request->saveAddressDeliveryRequest,
                $order->getDeliveryAddress()
            )
        );

        if (!$request->useInvoiceAddress) {
            //TODO: Jezeli byl ale teraz nie to trzebau sunac
            return $order;
        }

        $order->setInvoiceAddress(null === $order->getInvoiceAddress()
            ? $this->addressManager->createInvoiceAddress($request->saveAddressInvoiceRequest)
            : $this->addressManager->updateInvoiceAddress(
                $request->saveAddressInvoiceRequest,
                $order->getInvoiceAddress()
            )
        );
        $order->setCheckoutStep(CheckoutStep::ADDRESS);

        $this->orderRepository->save($order);

        return $order;
    }

    public function addCarrier(Order $order, Carrier $carrier): Order
    {
        $order->setCarrier($carrier);
        $order->setCheckoutStep(CheckoutStep::SHIPPING);

        $this->orderRepository->save($order);

        return $order;
    }

    public function addPaymentMethod(Order $order, PaymentMethod $paymentMethod): Order
    {
        $payment = new Payment();
        $payment->setOrder($order);
        $payment->setPaymentMethod($paymentMethod);
        $payment->setAmount($order->getTotalPrice());

        if (!$paymentMethod->isRequiresWebhook()) {
            $payment->setStatus(PaymentStatus::PENDING);
        }

        $order->addPayment($payment);
        $order->setPaymentMethod($paymentMethod);
        $order->setCheckoutStep(CheckoutStep::PAYMENT);

        $this->orderRepository->save($order);

        return $order;
    }

    public function confirmationOrder(Order $order): Order
    {
        $order->setCheckoutStep(CheckoutStep::CONFIRMATION);
        $this->orderRepository->save($order);


        //TODO: SendEmail
        return $order;
    }
}
