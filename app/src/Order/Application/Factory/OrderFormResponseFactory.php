<?php

declare (strict_types = 1);

namespace App\Order\Application\Factory;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Order\Application\Dto\Response\OrderFormResponse;

final readonly class OrderFormResponseFactory
{

    public function fromOrder(Order $order): OrderFormResponse
    {
        $contactDetails = $order->getOrderContactDetailsToUse();
        $deliveryAddress = $order->getDeliveryAddressToUse();
        $invoiceAddress = $order->getInvoiceAddressToUse();


        return new OrderFormResponse(
            checkoutStep: $order->getCheckoutStep()->value,
            status: $order->getStatus()->value,
            uuid: $order->getUuid(),
            carrierId: $order->getCarrier()?->getId(),
            paymentMethodId: $order->getPaymentMethod()?->getId(),
            isInvoice: $invoiceAddress !== null,
            firstname: $contactDetails?->getFirstname(),
            surname: $contactDetails?->getSurname(),
            email: $order->getEmail(),
            phone: $contactDetails?->getPhone(),
            postalCode: $deliveryAddress?->getAddress()?->getPostalCode(),
            city: $deliveryAddress?->getAddress()?->getCity(),
            street: $deliveryAddress?->getAddress()?->getStreet(),
            countryId: $deliveryAddress?->getAddress()?->getCountry()->getId(),
            deliveryInstructions: $deliveryAddress?->getDeliveryInstructions(),
            invoiceStreet: $invoiceAddress?->getAddress()?->getStreet(),
            invoiceCity: $invoiceAddress?->getAddress()?->getCity(),
            invoicePostalCode: $invoiceAddress?->getAddress()?->getPostalCode(),
            invoiceCountryId: $invoiceAddress?->getAddress()?->getCountry()->getId(),
            invoiceCompanyName: $invoiceAddress?->getCompanyName(),
            invoiceCompanyTaxId: $invoiceAddress?->getCompanyTaxId(),
            customerId: $order->getCustomer()?->getId(),
            products: $this->getProducts($order)
        );
    }


    private function getProducts(Order $order): array
    {
        return array_map(function (OrderItem $orderItem) {
            return [
                'productId' => $orderItem->getProduct()->getId(),
                'quantity' => $orderItem->getQuantity()
            ];
        }, $order->getOrderItems()->toArray());
    }
}
