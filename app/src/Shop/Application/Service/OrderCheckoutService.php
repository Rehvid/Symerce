<?php

declare(strict_types=1);

namespace App\Shop\Application\Service;

use App\Admin\Domain\Entity\Carrier;
use App\Admin\Domain\Entity\PaymentMethod;
use App\Shared\Domain\Entity\Cart;
use App\Shared\Domain\Entity\CartItem;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Enums\CheckoutStep;
use App\Shared\Domain\Repository\OrderRepositoryInterface;
use App\Shop\Application\Assembler\CartAssembler;
use App\Shop\Application\DTO\Request\Checkout\SaveCheckoutAddressRequest;
use App\Shop\Application\UseCase\Address\CreateDeliveryAddressUseCase;
use App\Shop\Application\UseCase\Address\CreateInvoiceAddressUseCase;
use App\Shop\Application\UseCase\Address\UpdateDeliveryAddressUseCase;
use App\Shop\Application\UseCase\Address\UpdateInvoiceAddressUseCase;
use App\Shop\Application\UseCase\ContactDetails\CreateContactDetailsUseCase;
use App\Shop\Application\UseCase\ContactDetails\UpdateContactDetailsUseCase;
use App\Shop\Application\UseCase\Payment\CreatePaymentUseCase;


//TODO: Split to small usecases
final readonly class OrderCheckoutService
{
    public function __construct(
        private CartAssembler         $cartService,
        private OrderRepositoryInterface       $orderRepository,
        private CreateDeliveryAddressUseCase $createDeliveryAddressUseCase,
        private UpdateDeliveryAddressUseCase $updateDeliveryAddressUseCase,
        private CreateInvoiceAddressUseCase $createInvoiceAddressUseCase,
        private UpdateInvoiceAddressUseCase $updateInvoiceAddressUseCase,
        private CreatePaymentUseCase $createPaymentUseCase,
        private CreateContactDetailsUseCase $createContactDetailsUseCase,
        private UpdateContactDetailsUseCase $updateContactDetailsUseCase,
    ) {
    }

    public function createOrder(SaveCheckoutAddressRequest $request, Cart $cart): Order
    {
        $order = new Order();
        $order->setCartToken($cart->getToken());
        $order->setDeliveryAddress($this->createDeliveryAddressUseCase->execute($request->saveAddressDeliveryRequest));

        if ($request->useInvoiceAddress) {
            $order->setInvoiceAddress($this->createInvoiceAddressUseCase->execute($request->saveAddressInvoiceRequest));
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
            $this->createContactDetailsUseCase->execute($request->saveContactDetailsRequest)
        );

        $this->orderRepository->save($order);

        return $order;
    }

    public function updateAddresses(SaveCheckoutAddressRequest $request, Order $order): Order
    {
        $order->setContactDetails(
            $this->updateContactDetailsUseCase->execute(
                $request->saveContactDetailsRequest,
                $order->getContactDetails()
            )
        );

        $order->setDeliveryAddress(
            $this->updateDeliveryAddressUseCase->execute(
                $request->saveAddressDeliveryRequest,
                $order->getDeliveryAddress()
            )
        );

        if (!$request->useInvoiceAddress) {
            //TODO: Jezeli byl ale teraz nie to trzebau sunac
            return $order;
        }

        $order->setInvoiceAddress(null === $order->getInvoiceAddress()
            ? $this->createInvoiceAddressUseCase->execute($request->saveAddressInvoiceRequest)
            : $this->updateInvoiceAddressUseCase->execute(
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
        $payment = $this->createPaymentUseCase->execute($order, $paymentMethod);

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
