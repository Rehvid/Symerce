<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Request\Checkout;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Shop\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;

final readonly class SaveCheckoutAddressRequest implements ArrayHydratableInterface
{
    public function __construct(
        public SaveContactDetailsRequest $saveContactDetailsRequest,
        public SaveAddressDeliveryRequest $saveAddressDeliveryRequest,
        public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest = null,
        public bool $useInvoiceAddress = false,
    ) {

    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $street = $data['street'] ?? null;
        $postalCode = $data['postalCode'] ?? null;
        $city = $data['city'] ?? null;
        $useInvoiceAddress = $data['useInvoiceAddress'] ?? false;

        $saveAddressInvoiceRequest = null;
        if ($useInvoiceAddress) {
            $saveAddressInvoiceRequest = new SaveAddressInvoiceRequest(
                street: $street,
                postalCode: $postalCode,
                city: $city,
                companyName: $data['companyName'] ?? null,
                companyTaxId: $data['companyTaxId'] ?? null,
            );
        }

        return new self(
            saveContactDetailsRequest: new SaveContactDetailsRequest(
                firstname: $data['firstname'] ?? null,
                surname: $data['surname'] ?? null,
                email: $data['email'] ?? null,
                phone: $data['phone'] ?? null,
            ),
            saveAddressDeliveryRequest: new SaveAddressDeliveryRequest(
                street: $street,
                postalCode: $postalCode,
                city: $city,
                deliveryInstructions: $data['deliveryInstructions'],
            ),
            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
            useInvoiceAddress: $useInvoiceAddress
        );
    }
}
