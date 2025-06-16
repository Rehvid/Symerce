<?php

declare(strict_types=1);

namespace App\Tests\Unit\Order\Application\Helper;

use App\Common\Domain\Entity\Product;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderItemData;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\Tests\Helper\AddressDataFactory;
use App\Tests\Helper\CarrierFactory;
use App\Tests\Helper\ContactDetailsDataFactory;
use App\Tests\Helper\CustomerFactory;
use App\Tests\Helper\PaymentMethodFactory;

final class OrderDataFactory
{
    /** @return OrderItemData[] */
    private static function createOrderItems(): array
    {

        return [
            new OrderItemData(
                product: new Product(),
                quantity: 2,
            ),
        ];
    }


    public static function validForGuest(): OrderData
    {
        return new OrderData(
            contactDetailsData: ContactDetailsDataFactory::valid(),
            email: 'john.doe@example.com',
            carrier: CarrierFactory::valid(),
            paymentMethod: PaymentMethodFactory::card(),
            checkoutStep: CheckoutStep::CONFIRMATION,
            orderStatus: OrderStatus::PAID,
            orderItems: self::createOrderItems(),
            deliveryAddressData: AddressDataFactory::valid(),
            deliveryInstructions: 'Leave at the door.',
            invoiceAddressData: AddressDataFactory::valid(),
            invoiceCompanyTaxId: '1234567890',
            invoiceCompanyName: 'Company Name',
            customer: null
        );
    }

    public static function validForCustomer(): OrderData
    {
        return new OrderData(
            contactDetailsData: ContactDetailsDataFactory::valid(),
            email: '',
            carrier: CarrierFactory::valid(),
            paymentMethod: PaymentMethodFactory::card(),
            checkoutStep: CheckoutStep::CONFIRMATION,
            orderStatus: OrderStatus::PAID,
            orderItems: self::createOrderItems(),
            deliveryAddressData: null,
            deliveryInstructions: null,
            invoiceAddressData: null,
            invoiceCompanyTaxId: null,
            invoiceCompanyName: null,
            customer: CustomerFactory::valid()
        );
    }
}
