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
    ) {}

    public function fromRequest(SaveCustomerRequest $customerRequest): CustomerData
    {
        $contactDetails = $customerRequest->saveContactDetailsRequest;
        $deliveryAddress = $customerRequest->saveAddressDeliveryRequest;
        $invoiceAddress = $customerRequest->saveAddressInvoiceRequest;
        $password = $customerRequest->password === '' ? null : $customerRequest->password;

        $deliveryAddressData = null;
        if ($deliveryAddress) {
            $deliveryAddressData = new AddressData(
                street: $deliveryAddress->saveAddressRequest->street,
                postalCode: $deliveryAddress->saveAddressRequest->postalCode,
                city: $deliveryAddress->saveAddressRequest->city,
                country: $this->countryRepository->findById($deliveryAddress->saveAddressRequest->country),
            );
        }

        $invoiceAddressData = null;
        if ($invoiceAddress) {
            $invoiceAddressData = new AddressData(
                street: $invoiceAddress->saveAddressRequest->street,
                postalCode: $invoiceAddress->saveAddressRequest->postalCode,
                city: $invoiceAddress->saveAddressRequest->city,
                country: $this->countryRepository->findById($invoiceAddress->saveAddressRequest->country),
            );
        }

        return new CustomerData (
            contactDetailsData: new ContactDetailsData(
                firstname: $contactDetails->firstname,
                surname: $contactDetails->surname,
                phone: $contactDetails->phone,
            ),
            email: $contactDetails->email,
            id: $customerRequest->id,
            password: $password,
            passwordConfirmation: $customerRequest->passwordConfirmation,
            deliveryAddressData: $deliveryAddressData,
            deliveryInstructions: $deliveryAddress?->deliveryInstructions,
            invoiceAddressData: $invoiceAddressData,
            companyName: $invoiceAddress?->companyName,
            companyTaxId: $invoiceAddress?->companyTaxId,
            isDelivery: $customerRequest->isDelivery,
            isInvoice: $customerRequest->isInvoice,
            isActive: $customerRequest->isActive,
        );
    }
}
