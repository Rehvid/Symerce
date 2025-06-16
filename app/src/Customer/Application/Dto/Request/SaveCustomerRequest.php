<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Application\Dto\Request\ContactDetails\SaveContactDetailsRequest;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Application\Dto\Request\SavePasswordRequest;
use App\Common\Domain\Entity\Customer;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCustomerRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssertUniqueEmail(options: ['field' => 'email', 'className' => Customer::class])]
    public string $email;

    #[Assert\Valid]
    public SavePasswordRequest $savePasswordRequest;

    #[Assert\Valid]
    public SaveContactDetailsRequest $saveContactDetailsRequest;

    #[Assert\Valid]
    public ?SaveAddressDeliveryRequest $saveAddressDeliveryRequest;

    #[Assert\Valid]
    public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest;

    public bool $isDelivery;

    public bool $isInvoice;

    public bool $isActive;

    public function __construct(
        ?string $password,
        ?string $passwordConfirmation,
        string $email,
        string $firstname,
        string $surname,
        string $phone,
        mixed $isDelivery,
        mixed $isInvoice,
        mixed $isActive,
        string $street,
        string $postalCode,
        string $city,
        ?string $deliveryInstructions,
        string $invoiceStreet,
        string $invoicePostalCode,
        string $invoiceCity,
        ?string $invoiceCompanyName,
        ?string $invoiceCompanyTaxId,
        null|int|string $invoiceCountryId,
        string|null|int $countryId,
        null|string|int $id,
    ) {
        $this->savePasswordRequest = new SavePasswordRequest($password, $passwordConfirmation);
        $this->email = $email;
        $this->saveContactDetailsRequest = new SaveContactDetailsRequest($firstname, $surname, $phone);
        $this->idRequest = new IdRequest($id);
        $this->isDelivery = BoolHelper::castOrFail($isDelivery, 'isDelivery');
        $this->isInvoice = BoolHelper::castOrFail($isInvoice, 'isInvoice');
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->saveAddressDeliveryRequest = $this->isDelivery ? new SaveAddressDeliveryRequest(
            $this->createSaveAddressRequest($street, $postalCode, $city, $countryId),
            $deliveryInstructions,
        ) : null;
        $this->saveAddressInvoiceRequest = $this->isInvoice ? new SaveAddressInvoiceRequest(
            $this->createSaveAddressRequest($invoiceStreet, $invoicePostalCode, $invoiceCity, $invoiceCountryId),
            $invoiceCompanyName,
            $invoiceCompanyTaxId,
        ) : null;
    }


    private function createSaveAddressRequest(
        string $street,
        string $postalCode,
        string $city,
        null|int|string $countryId,
    ): SaveAddressRequest {
        return new SaveAddressRequest(
            street: $street,
            postalCode: $postalCode,
            city: $city,
            countryId: $countryId
        );
    }


    public static function fromArray(array $data): ArrayHydratableInterface
    {
//        $isDelivery = $data['isDelivery'] ?? false;
//        $isInvoice = $data['isInvoice'] ?? false;
//        $isActive = $data['isActive'] ?? false;
//
//        $saveContactDetailsRequest = new SaveContactDetailsRequest(
//            firstname: $data['firstname'] ?? null,
//            surname: $data['surname'] ?? null,
//            phone: $data['phone'] ?? null,
//        );
//
//        $saveAddressDeliveryRequest = null;
//        if ($isDelivery) {
//            $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
//                saveAddressRequest: new SaveAddressRequest(
//                    street: $data['street'] ?? null,
//                    postalCode: $data['postalCode'] ?? null,
//                    city: $data['city'] ?? null,
//                    countryId: $data['countryId'] ?? null,
//                ),
//                deliveryInstructions: $data['deliveryInstructions'] ?? null,
//            );
//        }
//        $saveAddressInvoiceRequest = null;
//        if ($isInvoice) {
//            $saveAddressInvoiceRequest = new SaveAddressInvoiceRequest(
//                saveAddressRequest: new SaveAddressRequest(
//                    street: $data['invoiceStreet'] ?? null,
//                    postalCode: $data['invoicePostalCode'] ?? null,
//                    city: $data['invoiceCity'] ?? null,
//                    countryId: $data['invoiceCountryId'] ?? null,
//                ),
//                companyName: $data['invoiceCompanyName'] ?? null,
//                companyTaxId: $data['invoiceCompanyTaxId'] ?? null,
//            );
//        }
//
//        $passwordRequest = new SavePasswordRequest(
//            password: $data['password'] ?? null,
//            passwordConfirmation: $data['passwordConfirmation'] ?? null,
//        );
//
//        return new self(
//            passwordRequest: $passwordRequest,
//            email: $data['email'] ?? null,
//            saveContactDetailsRequest: $saveContactDetailsRequest,
//            id: $data['id'] ?? null,
//            saveAddressDeliveryRequest: $saveAddressDeliveryRequest,
//            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
//            isDelivery: $isDelivery,
//            isInvoice: $isInvoice,
//            isActive: $isActive,
//        );
    }
}
