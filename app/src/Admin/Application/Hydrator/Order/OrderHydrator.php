<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Order;

use App\Admin\Application\DTO\Request\Order\SaveOrderProductRequest;
use App\Admin\Application\DTO\Request\Order\SaveOrderRequest;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\DTO\Request\Address\SaveAddressDeliveryRequest;
use App\Shared\Application\DTO\Request\Address\SaveAddressInvoiceRequest;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Application\Factory\OrderItemFactory;
use App\Shared\Application\Factory\ValidationExceptionFactory;
use App\Shared\Application\Hydrator\AddressHydrator;
use App\Shared\Application\Hydrator\ContactDetailsHydrator;
use App\Shared\Domain\Entity\DeliveryAddress;
use App\Shared\Domain\Entity\InvoiceAddress;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Entity\OrderItem;
use App\Shared\Domain\Enums\CheckoutStep;
use App\Shared\Domain\Enums\OrderStatus;
use App\Shared\Domain\Service\OrderPriceCalculator;
use App\Shared\Domain\Service\ProductPriceCalculator;

final readonly class OrderHydrator
{
    public function __construct(
        public ContactDetailsHydrator $contactDetailsHydrator,
        public AddressHydrator $addressHydrator,
        public PaymentMethodRepositoryInterface $paymentMethodRepository,
        public CarrierRepositoryInterface $carrierRepository,
        public ProductRepositoryInterface $productRepository,
        public ValidationExceptionFactory $validationExceptionFactory,
        public MoneyFactory $moneyFactory,
        public ProductPriceCalculator $productPriceCalculator,
        public OrderItemFactory $orderItemFactory,
        public OrderPriceCalculator $orderPriceCalculator,
    ) {

    }

    public function hydrate(SaveOrderRequest $request, ?Order $order = null): Order
    {
        $order = $order ?? new Order();
        $order->setContactDetails($this->contactDetailsHydrator->hydrate($request->saveContactDetailsRequest));
        $order->setDeliveryAddress(
            $this->hydrateDeliveryAddress($request->saveAddressDeliveryRequest, $order->getDeliveryAddress())
        );
        if ($request->isInvoice) {
            $order->setInvoiceAddress(
                $this->hydrateInvoiceAddress($request->saveAddressInvoiceRequest, $order->getInvoiceAddress())
            );
        }
        $this->setCarrier($request->carrierId, $order);
        $this->setPaymentMethod($request->paymentMethodId, $order);
        $this->addOrderItem($request->saveOrderProductRequestCollection, $order);

        $order->setCartToken('temporary');
        $order->setCheckoutStep(CheckoutStep::tryFrom($request->checkoutStep));
        $order->setStatus(OrderStatus::tryFrom($request->status));
        $order->setTotalPrice($this->orderPriceCalculator->calculateTotal($order)?->getAmount());

        return $order;
    }

    private function hydrateDeliveryAddress(
        SaveAddressDeliveryRequest $request,
        ?DeliveryAddress $deliveryAddress = null
    ): DeliveryAddress {
        $deliveryAddress = $deliveryAddress ?? new DeliveryAddress();
        $deliveryAddress->setAddress($this->addressHydrator->hydrate($request->saveAddressRequest));
        $deliveryAddress->setDeliveryInstructions($request->deliveryInstructions);

        return $deliveryAddress;
    }

    private function hydrateInvoiceAddress(
        SaveAddressInvoiceRequest $request,
        ?InvoiceAddress $invoiceAddress = null
    ): InvoiceAddress
    {
        $invoiceAddress = $invoiceAddress ?? new InvoiceAddress();
        $invoiceAddress->setAddress($this->addressHydrator->hydrate($request->saveAddressRequest));
        $invoiceAddress->setCompanyTaxId($request->companyTaxId);
        $invoiceAddress->setCompanyName($request->companyName);

        return $invoiceAddress;
    }

    public function setCarrier(int $carrierId, Order $order): void
    {
        $carrier = $this->carrierRepository->findById($carrierId);
        if (null === $carrier) {
            $this->validationExceptionFactory->createNotFound('carrierId');
        }

        $order->setCarrier($carrier);
    }

    public function setPaymentMethod(int $paymentMethodId, Order $order): void
    {
        $paymentMethod = $this->paymentMethodRepository->findById($paymentMethodId);
        if (null === $paymentMethod) {
            $this->validationExceptionFactory->createNotFound('paymentMethodId');
        }

        $order->setPaymentMethod($paymentMethod);
    }


    /** @param SaveOrderProductRequest[] $saveOrderProductRequestCollection */
    public function addOrderItem(array $saveOrderProductRequestCollection, Order $order): void
    {
        $order->getOrderItems()->clear();


        foreach ($saveOrderProductRequestCollection as $saveOrderProductRequest) {
            $order->addOrderItem($this->createOrderItem($saveOrderProductRequest, $order));
        }
    }

    private function createOrderItem(SaveOrderProductRequest $saveOrderProductRequest, Order $order): OrderItem
    {
        /** @var Product $product */
        $product = $this->productRepository->findById($saveOrderProductRequest->productId);
        if (null === $product) {
            $this->validationExceptionFactory->createNotFound('productId');
        }

        return $this->orderItemFactory->create(
            quantity: (int) $saveOrderProductRequest->quantity,
            product: $product,
            order: $order,
        );
    }
}
