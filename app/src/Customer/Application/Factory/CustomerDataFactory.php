<?php

declare(strict_types=1);

namespace App\Customer\Application\Factory;

use App\Common\Application\Dto\AddressData;
use App\Common\Application\Dto\ContactDetailsData;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Customer\Application\Dto\CustomerData;
use App\Customer\Application\Dto\Request\SaveCustomerRequest;

final readonly class CustomerDataFactory
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository
    ) {
    }

    public function fromRequest(SaveCustomerRequest $customerRequest): CustomerData
    {
        $contactDetails = $customerRequest->saveContactDetailsRequest;
        $deliveryAddress = $customerRequest->saveAddressDeliveryRequest;
        $invoiceAddress = $customerRequest->saveAddressInvoiceRequest;
        $password = '' === $customerRequest->savePasswordRequest->password ? null : $customerRequest->savePasswordRequest->password;

        $deliveryAddressData = null;
        if ($deliveryAddress) {
            $deliveryAddressData = new AddressData(
                street: $deliveryAddress->saveAddressRequest->street,
                postalCode: $deliveryAddress->saveAddressRequest->postalCode,
                city: $deliveryAddress->saveAddressRequest->city,
                country: $this->countryRepository->findById($deliveryAddress->saveAddressRequest->countryIdRequest->getId()),
            );
        }

        $invoiceAddressData = null;
        if ($invoiceAddress) {
            $invoiceAddressData = new AddressData(
                street: $invoiceAddress->saveAddressRequest->street,
                postalCode: $invoiceAddress->saveAddressRequest->postalCode,
                city: $invoiceAddress->saveAddressRequest->city,
                country: $this->countryRepository->findById($invoiceAddress->saveAddressRequest->countryIdRequest->getId()),
            );
        }

        return new CustomerData(
            contactDetailsData: new ContactDetailsData(
                firstname: $contactDetails->firstname,
                surname: $contactDetails->surname,
                phone: $contactDetails->phone,
            ),
            email: $customerRequest->email,
            id: $customerRequest->idRequest->getId(),
            password: $password,
            passwordConfirmation: $customerRequest->savePasswordRequest->passwordConfirmation,
            deliveryAddressData: $deliveryAddressData,
            deliveryInstructions: $deliveryAddress?->deliveryInstructions,
            invoiceAddressData: $invoiceAddressData,
            companyName: $invoiceAddress?->invoiceCompanyName,
            companyTaxId: $invoiceAddress?->invoiceCompanyTaxId,
            isDelivery: $customerRequest->isDelivery,
            isInvoice: $customerRequest->isInvoice,
            isActive: $customerRequest->isActive,
        );
    }
}
