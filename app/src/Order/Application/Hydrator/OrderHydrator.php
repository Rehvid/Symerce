<?php

declare(strict_types=1);

namespace App\Order\Application\Hydrator;

use App\Common\Application\Dto\AddressData;
use App\Common\Application\Factory\OrderItemFactory;
use App\Common\Application\Hydrator\AddressHydrator;
use App\Common\Application\Hydrator\ContactDetailsHydrator;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\ContactDetails;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\Service\ProductPriceCalculator;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderItemData;
use App\Order\Application\Service\OrderPriceCalculator;

readonly class OrderHydrator
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
        if (null === $data->customer) {
            $this->hydrateGuestData($data, $order);
        } else {
            $order->setContactDetails(null);
            $order->setDeliveryAddress(null);
            $order->setInvoiceAddress(null);
        }

        $order->setCustomer($data->customer);
        $order->setCarrier($data->carrier);
        $order->setPaymentMethod($data->paymentMethod);
        $order->setEmail($data->email);
        $order->setCheckoutStep($data->checkoutStep);
        $order->setStatus($data->orderStatus);

        $this->addOrderItem($data->orderItems, $order);

        $orderPriceSummary = $this->orderPriceCalculator->calculatePriceSummary($order);
        $order->setTotalPrice($orderPriceSummary?->total->getAmount());

        return $order;
    }

    private function hydrateGuestData(OrderData $data, Order $order): void
    {
        $order->setContactDetails(
            $this->contactDetailsHydrator->hydrate(
                data: $data->contactDetailsData,
                contactDetails: $order->getContactDetails() ?? new ContactDetails(),
            )
        );

        $order->setDeliveryAddress($this->hydrateDeliveryAddress($data, $order->getDeliveryAddress()));

        if (null === $data->invoiceAddressData) {
            $order->setInvoiceAddress(null);

            return;
        }

        $order->setInvoiceAddress(
            $this->hydrateInvoiceAddress(
                data: $data,
                invoiceAddress: $order->getInvoiceAddress()
            )
        );
    }

    private function hydrateDeliveryAddress(
        OrderData $data,
        ?DeliveryAddress $deliveryAddress = null
    ): DeliveryAddress {
        $address = $deliveryAddress ?? new DeliveryAddress();

        /** @var AddressData $deliveryAddressData */
        $deliveryAddressData = $data->deliveryAddressData;

        $address->setAddress(
            $this->addressHydrator->hydrate(
                data: $deliveryAddressData,
                address: null === $address->getAddress() ? new Address() : $address->getAddress(),
            )
        );
        $address->setDeliveryInstructions($data->deliveryInstructions);

        return $address;
    }

    private function hydrateInvoiceAddress(
        OrderData $data,
        ?InvoiceAddress $invoiceAddress = null
    ): InvoiceAddress {
        /** @var AddressData $invoiceAddressData */
        $invoiceAddressData = $data->invoiceAddressData;

        /** @var InvoiceAddress $address */
        $address = $invoiceAddress ?? new InvoiceAddress();


        $existing = $address->getAddress();
        $finalAddress = $existing instanceof Address ? $existing : new Address();

        $address->setAddress(
            $this->addressHydrator->hydrate(
                data: $invoiceAddressData,
                address: $finalAddress,
            )
        );
        $address->setCompanyTaxId($data->invoiceCompanyTaxId);
        $address->setCompanyName($data->invoiceCompanyName);

        return $address;
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
