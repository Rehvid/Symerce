<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Request;

use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\Address\SaveAddressDeliveryRequest;
use App\Shared\Application\DTO\Request\Address\SaveAddressInvoiceRequest;
use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;
use App\Shared\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shared\Application\DTO\Request\RequestDtoInterface;

final readonly class SaveCustomerRequest implements ArrayHydratableInterface
{
    public function __construct(
        public ?int $id = null,
        public string $password,
        public string $passwordConfirmation,
        public SaveContactDetailsRequest  $saveContactDetailsRequest,
        public ?SaveAddressDeliveryRequest $saveAddressDeliveryRequest = null,
        public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest = null,
        public bool $isDelivery = false,
        public bool $isInvoice = false,
        public bool $isActive = false,
    ) {}

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $isDelivery = $data['isDelivery'] ?? false;
        $isInvoice = $data['isInvoice'] ?? false;
        $isActive = $data['isActive'] ?? false;
        $password = $data['password'] ?? null;
        $passwordConfirmation = $data['passwordConfirmation'] ?? null;

        $saveContactDetailsRequest = new SaveContactDetailsRequest(
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
        );

        $saveAddressDeliveryRequest = null;
        if ($isDelivery) {
            $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
                saveAddressRequest: new SaveAddressRequest(
                    street: $data['street'] ?? null,
                    postalCode: $data['postalCode'] ?? null,
                    city: $data['city'] ?? null,
                    country: $data['country'] ?? null,
                ),
                deliveryInstructions: $data['deliveryInstructions'] ?? null,
            );
        }
        $saveAddressInvoiceRequest = null;
        if ($isInvoice) {
            $saveAddressInvoiceRequest = new SaveAddressInvoiceRequest(
                saveAddressRequest: new SaveAddressRequest(
                    street: $data['invoiceStreet'] ?? null,
                    postalCode: $data['invoicePostalCode'] ?? null,
                    city: $data['invoiceCity'] ?? null,
                    country: $data['invoiceCountry'] ?? null,
                ),
                companyName: $data['invoiceCompanyName'] ?? null,
                companyTaxId: $data['invoiceCompanyTaxId'] ?? null,
            );
        }

        return new self(
            id: $data['id'] ?? null,
            password: $password,
            passwordConfirmation: $passwordConfirmation,
            saveContactDetailsRequest: $saveContactDetailsRequest,
            saveAddressDeliveryRequest: $saveAddressDeliveryRequest,
            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
            isDelivery: $isDelivery,
            isInvoice: $isInvoice,
            isActive: $isActive,
        );
    }
}
