<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Application\Dto\Request\ContactDetails\SaveContactDetailsRequest;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveOrderRequest implements ArrayHydratableInterface
{
    //TODO: Add customer for option

    public SaveContactDetailsRequest  $saveContactDetailsRequest;
    public SaveAddressDeliveryRequest $saveAddressDeliveryRequest;

    #[Assert\GreaterThan(0)]
    public int $paymentMethodId;

    #[Assert\GreaterThan(0)]
    public int $carrierId;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [CheckoutStep::class, 'values'])]
    public string $checkoutStep;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [OrderStatus::class, 'values'])]
    public string $status;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    public bool $isInvoice;

    public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest;

    public array $saveOrderProductRequestCollection;

    /** @param SaveOrderProductRequest[] $saveOrderProductRequestCollection */
    public function __construct(
        SaveContactDetailsRequest  $saveContactDetailsRequest,
        SaveAddressDeliveryRequest $saveAddressDeliveryRequest,
        int $paymentMethodId,
        int $carrierId,
        string $checkoutStep,
        string $status,
        string $email,
        bool $isInvoice = false,
        ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest = null,
        array $saveOrderProductRequestCollection = [],
    ) {
        $this->saveContactDetailsRequest = $saveContactDetailsRequest;
        $this->saveAddressDeliveryRequest = $saveAddressDeliveryRequest;
        $this->paymentMethodId = $paymentMethodId;
        $this->carrierId = $carrierId;
        $this->checkoutStep = $checkoutStep;
        $this->status = $status;
        $this->isInvoice = $isInvoice;
        $this->saveOrderProductRequestCollection = $saveOrderProductRequestCollection;
        $this->saveAddressInvoiceRequest = $saveAddressInvoiceRequest;
        $this->email = $email;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $saveContactDetailsRequest = new SaveContactDetailsRequest(
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            phone: $data['phone'] ?? null,
        );

        $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
            saveAddressRequest: new SaveAddressRequest(
                street: $data['street'] ?? null,
                postalCode: $data['postalCode'] ?? null,
                city: $data['city'] ?? null,
                countryId: $data['countryId'] ?? null,
            ),
            deliveryInstructions: $data['deliveryInstructions'] ?? null,
        );

        $saveAddressInvoiceRequest = null;
        $isInvoice = $data['isInvoice'] ?? false;
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

        $saveOrderProductRequestCollection = [];
        $saveProductsRequest = $data['products'] ?? [];
        foreach ($saveProductsRequest as $productRequest) {
            $saveOrderProductRequestCollection[] = new SaveOrderProductRequest(
                productId: $productRequest['productId'] ?? null,
                quantity: $productRequest['quantity'] ?? null,
            );
        }

        return new self(
            saveContactDetailsRequest: $saveContactDetailsRequest,
            saveAddressDeliveryRequest: $saveAddressDeliveryRequest,
            paymentMethodId: $data['paymentMethodId'] ?? null,
            carrierId: $data['carrierId'] ?? null,
            checkoutStep: $data['checkoutStep'] ?? null,
            status: $data['status'] ?? null,
            email: $data['email'] ?? null,
            isInvoice: $isInvoice,
            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
            saveOrderProductRequestCollection: $saveOrderProductRequestCollection
        );
    }
}
