<?php

declare(strict_types=1);

namespace App\Order\Application\Mapper;

use App\Customer\Application\Dto\CustomerData;
use App\Order\Application\Dto\OrderData;

final readonly class OrderDataToCustomerDataMapper
{
    public function map(OrderData $data): CustomerData
    {
        $invoice = $data->invoiceAddressData;

        return new CustomerData(
            contactDetailsData: $data->contactDetailsData,
            email: $data->email,
            deliveryAddressData: $data->deliveryAddressData,
            deliveryInstructions: $data->deliveryInstructions,
            invoiceAddressData: $invoice,
            companyName: $data->invoiceCompanyName,
            companyTaxId: $data->invoiceCompanyTaxId,
            isDelivery: true,
            isInvoice: null !== $invoice,
        );
    }
}
