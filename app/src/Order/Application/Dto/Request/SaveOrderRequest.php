<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\Address\SaveAddressDeliveryRequest;
use App\Shared\Application\DTO\Request\Address\SaveAddressInvoiceRequest;
use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;
use App\Shared\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shared\Application\DTO\Request\RequestDtoInterface;

final readonly class SaveOrderRequest implements RequestDtoInterface, ArrayHydratableInterface
{
    /** @param SaveOrderProductRequest[] $saveOrderProductRequestCollection */
    public function __construct(
        public SaveContactDetailsRequest  $saveContactDetailsRequest,
        public SaveAddressDeliveryRequest $saveAddressDeliveryRequest,
        public int                        $paymentMethodId,
        public int                        $carrierId,
        public string $checkoutStep,
        public string $status,
        public bool $isInvoice = false,
        public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest = null,
        public array                      $saveOrderProductRequestCollection = []
    ) {

    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $saveContactDetailsRequest = new SaveContactDetailsRequest(
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
        );

        $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
            saveAddressRequest: new SaveAddressRequest(
                street: $data['street'] ?? null,
                postalCode: $data['postalCode'] ?? null,
                city: $data['city'] ?? null,
                country: $data['country'] ?? null,
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
                    country: $data['invoiceCountry'] ?? null,
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
            isInvoice: $isInvoice,
            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
            saveOrderProductRequestCollection: $saveOrderProductRequestCollection,
        );
    }
}
