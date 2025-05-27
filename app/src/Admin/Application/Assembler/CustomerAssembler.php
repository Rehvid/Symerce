<?php

declare (strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Customer\CustomerFormResponse;
use App\Admin\Application\DTO\Response\Customer\CustomerListResponse;
use App\Shared\Domain\Entity\Customer;

final readonly class CustomerAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler
    ) {}

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $collection = array_map(
            fn (Customer $customer) => $this->createCustomerListResponse($customer),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($collection);
    }

    private function createCustomerListResponse(Customer $customer): CustomerListResponse
    {
        return new CustomerListResponse(
            id: $customer->getId(),
            fullName: $customer->getContactDetails()->getFullName(),
            email: $customer->getContactDetails()->getEmail(),
            isActive: $customer->isActive(),
        );
    }

    public function toFormResponse(Customer $customer): array
    {
        $contactDetails = $customer->getContactDetails();
        $deliveryAddress = $customer->getDeliveryAddress();
        $invoiceAddress = $customer->getInvoiceAddress();

        $response = new CustomerFormResponse(
            firstname: $contactDetails->getFirstname(),
            surname: $contactDetails->getSurname(),
            email: $contactDetails->getEmail(),
            phone: $contactDetails->getPhone(),
            isActive: $customer->isActive(),
            isDelivery: $deliveryAddress !== null,
            isInvoice: $invoiceAddress !== null,
            street: $deliveryAddress?->getAddress()?->getStreet(),
            postalCode: $deliveryAddress?->getAddress()?->getPostalCode(),
            city: $deliveryAddress?->getAddress()?->getCity(),
            deliveryInstructions: $deliveryAddress?->getDeliveryInstructions(),
            invoiceStreet: $invoiceAddress?->getAddress()->getStreet(),
            invoicePostalCode: $invoiceAddress?->getAddress()->getPostalCode(),
            invoiceCity: $invoiceAddress?->getAddress()->getCity(),
            invoiceCompanyName: $invoiceAddress?->getCompanyName(),
            invoiceCompanyTaxId: $invoiceAddress?->getCompanyTaxId(),
        );

        return $this->responseHelperAssembler->wrapFormResponse(data: $response);
    }
}
