<?php

declare(strict_types=1);

namespace App\Order\Application\Hydrator;

use App\Common\Application\Factory\OrderItemFactory;
use App\Common\Application\Hydrator\AddressHydrator;
use App\Common\Application\Hydrator\ContactDetailsHydrator;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\Service\ProductPriceCalculator;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderItemData;
use App\Order\Application\Service\OrderPriceCalculator;

final readonly class OrderHydrator
{
    public function __construct(
        public ContactDetailsHydrator $contactDetailsHydrator,
        public AddressHydrator $addressHydrator,
        public ProductPriceCalculator $productPriceCalculator,
        public OrderItemFactory $orderItemFactory,
        public OrderPriceCalculator $orderPriceCalculator,
    ) {

    }

    public function hydrate(OrderData $data, Order $order): Order
    {
        $order->setContactDetails($this->contactDetailsHydrator->hydrate($data->contactDetailsData));
        $order->setCarrier($data->carrier);
        $order->setPaymentMethod($data->paymentMethod);
        $order->setEmail($data->email);
        $order->setCheckoutStep($data->checkoutStep);
        $order->setStatus($data->orderStatus);

        $order->setDeliveryAddress($this->hydrateDeliveryAddress($data, $order->getDeliveryAddress()));

        if (null === $data->invoiceAddressData) {
            $order->setInvoiceAddress(null);
        } else {
            $order->setInvoiceAddress($this->hydrateInvoiceAddress($data, $order->getInvoiceAddress()));
        }
        $this->addOrderItem($data->orderItems, $order);

        $orderPriceSummary = $this->orderPriceCalculator->calculatePriceSummary($order);
        $order->setTotalPrice($orderPriceSummary?->total->getAmount());

        return $order;
    }

    private function hydrateDeliveryAddress(
        OrderData $data,
        ?DeliveryAddress $deliveryAddress = null
    ): DeliveryAddress {
        $deliveryAddress = $deliveryAddress ?? new DeliveryAddress();
        $deliveryAddress->setAddress($this->addressHydrator->hydrate($data->deliveryAddressData));
        $deliveryAddress->setDeliveryInstructions($data->deliveryInstructions);

        return $deliveryAddress;
    }

    private function hydrateInvoiceAddress(
        OrderData $data,
        ?InvoiceAddress $invoiceAddress = null
    ): InvoiceAddress
    {
        $invoiceAddress = $invoiceAddress ?? new InvoiceAddress();
        $invoiceAddress->setAddress($this->addressHydrator->hydrate($data->invoiceAddressData));
        $invoiceAddress->setCompanyTaxId($data->companyTaxId);
        $invoiceAddress->setCompanyName($data->companyName);

        return $invoiceAddress;
    }


    /** @param OrderItemData[] $orderItems */
    public function addOrderItem(array $orderItems, Order $order): void
    {
        $order->getOrderItems()->clear();

        foreach ($orderItems as $orderItem) {
            $order->addOrderItem($this->createOrderItem($orderItem, $order));
        }
    }

    private function createOrderItem(OrderItemData $orderItem, Order $order): OrderItem
    {
        return $this->orderItemFactory->create(
            quantity: $orderItem->quantity,
            product: $orderItem->product,
            order: $order,
        );
    }
}
