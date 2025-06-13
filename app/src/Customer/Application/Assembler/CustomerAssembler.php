<?php

declare (strict_types=1);

namespace App\Customer\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Entity\Customer;
use App\Common\Infrastructure\Utils\ArrayUtils;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Customer\Application\Dto\Response\CustomerFormContext;
use App\Customer\Application\Dto\Response\CustomerFormResponse;
use App\Customer\Application\Dto\Response\CustomerListResponse;

final readonly class CustomerAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private CountryRepositoryInterface $countryRepository,
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

    public function toFormContextResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            context: new CustomerFormContext(
                availableCountries: $this->getAvailableCountries(),
            ),
        );
    }

    private function createCustomerListResponse(Customer $customer): CustomerListResponse
    {
        return new CustomerListResponse(
            id: $customer->getId(),
            fullName: $customer->getContactDetails()?->getFullName() ?? '-',
            email: $customer->getEmail(),
            isActive: $customer->isActive(),
        );
    }

    public function toFormResponse(Customer $customer): array
    {
        $contactDetails = $customer->getContactDetails();
        $deliveryAddress = $customer->getDeliveryAddress();
        $invoiceAddress = $customer->getInvoiceAddress();

        $response = new CustomerFormResponse(
            firstname: $contactDetails?->getFirstname(),
            surname: $contactDetails?->getSurname(),
            email: $customer->getEmail(),
            phone: $contactDetails?->getPhone(),
            isActive: $customer->isActive(),
            isDelivery: $deliveryAddress !== null,
            isInvoice: $invoiceAddress !== null,
            street: $deliveryAddress?->getAddress()?->getStreet(),
            postalCode: $deliveryAddress?->getAddress()?->getPostalCode(),
            city: $deliveryAddress?->getAddress()?->getCity(),
            deliveryInstructions: $deliveryAddress?->getDeliveryInstructions(),
            countryId: $deliveryAddress?->getAddress()?->getCountry()->getId(),
            invoiceStreet: $invoiceAddress?->getAddress()?->getStreet(),
            invoicePostalCode: $invoiceAddress?->getAddress()?->getPostalCode(),
            invoiceCity: $invoiceAddress?->getAddress()?->getCity(),
            invoiceCompanyName: $invoiceAddress?->getCompanyName(),
            invoiceCompanyTaxId: $invoiceAddress?->getCompanyTaxId(),
            invoiceCountryId: $invoiceAddress?->getAddress()?->getCountry()->getId(),
        );

        return $this->responseHelperAssembler->wrapFormResponse(
            data: $response,
            context: [
                'availableCountries' =>  $this->getAvailableCountries()
            ]
        );
    }

    private function getAvailableCountries(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: $this->countryRepository->findBy(['isActive' => true]),
            labelCallback: fn (Country $country) => $country->getName(),
            valueCallback: fn (Country $country) => $country->getId()
        );
    }
}
