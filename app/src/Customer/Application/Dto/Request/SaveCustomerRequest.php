<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Application\Dto\Request\ContactDetails\SaveContactDetailsRequest;
use App\Common\Application\Dto\Request\SavePasswordRequest;
use App\Common\Domain\Entity\Customer;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCustomerRequest implements ArrayHydratableInterface
{
    #[Assert\When(
        expression: 'this.id !== null',
        constraints: [
            new Assert\GreaterThan(value: 0)
        ]
    )]
    public ?int $id;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => Customer::class])]
    public string $email;

    public SavePasswordRequest $savePasswordRequest;

    public SaveContactDetailsRequest $saveContactDetailsRequest;

    public ?SaveAddressDeliveryRequest $saveAddressDeliveryRequest;

    public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest;

    public bool $isDelivery;

    public bool $isInvoice;

    public bool $isActive;

    public function __construct(
        SavePasswordRequest $passwordRequest,
        string $email,
        SaveContactDetailsRequest $saveContactDetailsRequest,
        ?int $id = null,
        ?SaveAddressDeliveryRequest $saveAddressDeliveryRequest = null,
        ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest = null,
        bool $isDelivery = false,
        bool $isInvoice = false,
        bool $isActive = false,
    ) {
        $this->email = $email;
        $this->savePasswordRequest = $passwordRequest;
        $this->saveContactDetailsRequest = $saveContactDetailsRequest;
        $this->id = $id;
        $this->saveAddressDeliveryRequest = $saveAddressDeliveryRequest;
        $this->saveAddressInvoiceRequest = $saveAddressInvoiceRequest;
        $this->isDelivery = $isDelivery;
        $this->isInvoice = $isInvoice;
        $this->isActive = $isActive;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $isDelivery = $data['isDelivery'] ?? false;
        $isInvoice = $data['isInvoice'] ?? false;
        $isActive = $data['isActive'] ?? false;

        $saveContactDetailsRequest = new SaveContactDetailsRequest(
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            phone: $data['phone'] ?? null,
        );

        $saveAddressDeliveryRequest = null;
        if ($isDelivery) {
            $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
                saveAddressRequest: new SaveAddressRequest(
                    street: $data['street'] ?? null,
                    postalCode: $data['postalCode'] ?? null,
                    city: $data['city'] ?? null,
                    countryId: $data['countryId'] ?? null,
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
                    countryId: $data['invoiceCountryId'] ?? null,
                ),
                companyName: $data['invoiceCompanyName'] ?? null,
                companyTaxId: $data['invoiceCompanyTaxId'] ?? null,
            );
        }

        $passwordRequest = new SavePasswordRequest(
            password: $data['password'] ?? null,
            passwordConfirmation: $data['passwordConfirmation'] ?? null,
        );

        return new self(
            passwordRequest: $passwordRequest,
            saveContactDetailsRequest: $saveContactDetailsRequest,
            id: $data['id'] ?? null,
            saveAddressDeliveryRequest: $saveAddressDeliveryRequest,
            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
            isDelivery: $isDelivery,
            isInvoice: $isInvoice,
            isActive: $isActive,
            email: $data['email'] ?? null,
        );
    }
}
