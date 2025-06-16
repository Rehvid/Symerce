<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Helper;

use App\Customer\Application\Dto\CustomerData;
use App\Tests\Helper\AddressDataFactory;
use App\Tests\Helper\ContactDetailsDataFactory;

final class CustomerDataFactory
{
    public static function valid(): CustomerData
    {
        return new CustomerData(
            contactDetailsData: ContactDetailsDataFactory::valid(),
            email: 'john.doe@example.com',
            password: 'securePassword123',
            passwordConfirmation: 'securePassword123',
            deliveryAddressData: AddressDataFactory::valid(),
            deliveryInstructions: 'Leave at the door.',
            invoiceAddressData: AddressDataFactory::valid(),
            companyName: 'Acme Corp.',
            companyTaxId: '1234567890',
            isDelivery: true,
            isInvoice: true,
            isActive: true
        );
    }

    public static function withoutInvoice(): CustomerData
    {
        $data = self::valid();
        return new CustomerData(
            contactDetailsData: $data->contactDetailsData,
            email: $data->email,
            password: $data->password,
            passwordConfirmation: $data->passwordConfirmation,
            deliveryAddressData: $data->deliveryAddressData,
            deliveryInstructions: $data->deliveryInstructions,
            invoiceAddressData: null,
            companyName: null,
            companyTaxId: null,
            isDelivery: $data->isDelivery,
            isInvoice: false,
            isActive: $data->isActive
        );
    }

    public static function withEmptyPassword(): CustomerData
    {
        $data = self::valid();
        return new CustomerData(
            contactDetailsData: $data->contactDetailsData,
            email: $data->email,
            password: null,
            passwordConfirmation: null,
            deliveryAddressData: $data->deliveryAddressData,
            deliveryInstructions: $data->deliveryInstructions,
            invoiceAddressData: $data->invoiceAddressData,
            companyName: $data->companyName,
        );
    }

    public static function withoutDelivery(): CustomerData
    {
        $data = self::valid();
        return new CustomerData(
            contactDetailsData: $data->contactDetailsData,
            email: $data->email,
            password: $data->password,
            passwordConfirmation: $data->passwordConfirmation,
            deliveryAddressData: null,
            deliveryInstructions: null,
            invoiceAddressData: $data->invoiceAddressData,
            companyName: $data->companyName,
        );
    }

    public static function empty(): CustomerData
    {
        return new CustomerData(
            contactDetailsData: ContactDetailsDataFactory::empty(),
            email: '',
            password: null,
            passwordConfirmation: null,
            deliveryAddressData: null,
            deliveryInstructions: null,
            invoiceAddressData: null,
            companyName: null,
            companyTaxId: null,
            isDelivery: false,
            isInvoice: false,
            isActive: false
        );
    }
}
