<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Application\Dto\Request\ContactDetails\SaveContactDetailsRequest;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveOrderRequest
{

    #[Assert\Valid]
    public SaveContactDetailsRequest  $saveContactDetailsRequest;

    #[Assert\Valid]
    public ?SaveAddressDeliveryRequest $saveAddressDeliveryRequest;

    #[Assert\Valid]
    public IdRequest $paymentMethodIdRequest;

    #[Assert\Valid]
    public IdRequest $carrierIdRequest;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [CheckoutStep::class, 'values'])]
    public string $checkoutStep;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [OrderStatus::class, 'values'])]
    public string $status;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\Valid]
    public ?SaveAddressInvoiceRequest $saveAddressInvoiceRequest;

    #[Assert\Valid]
    public IdRequest $customerIdRequest;

    /** @var SaveOrderProductRequest[] $saveOrderProductRequestCollection */
    #[Assert\Valid]
    public array $saveOrderProductRequestCollection;

    public bool $isInvoice;


    /** @param array<int,mixed> $products */
    public function __construct(
        string $firstname,
        string $surname,
        string $phone,
        string $street,
        string $postalCode,
        string $city,
        int|string|null $countryId,
        ?string $deliveryInstructions,
        int|string|null  $paymentMethodId,
        int|string|null  $carrierId,
        string $checkoutStep,
        string $status,
        string $email,
        mixed $isInvoice,
        ?string $invoiceStreet,
        ?string $invoicePostalCode,
        ?string $invoiceCity,
        ?string $invoiceCompanyName,
        ?string $invoiceCompanyTaxId,
        int|string|null $invoiceCountryId,
        array $products = [],
        ?int $customerId = null,
    ) {
        $this->saveContactDetailsRequest = new SaveContactDetailsRequest($firstname, $surname, $phone);
        $this->saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
            $this->createSaveAddressRequest($street, $postalCode, $city, $countryId),
            $deliveryInstructions,
        );
        $this->paymentMethodIdRequest = new IdRequest($paymentMethodId);
        $this->carrierIdRequest = new IdRequest($carrierId);
        $this->checkoutStep = $checkoutStep;
        $this->status = $status;
        $this->isInvoice = BoolHelper::castOrFail($isInvoice, 'isInvoice');
        $this->saveOrderProductRequestCollection = $this->createSaveOrderProductRequest($products);
        $this->saveAddressInvoiceRequest = $this->isInvoice ? new SaveAddressInvoiceRequest(
            $this->createSaveAddressRequest($invoiceStreet, $invoicePostalCode, $invoiceCity, $invoiceCountryId),
            $invoiceCompanyName,
            $invoiceCompanyTaxId,
        ) : null;
        $this->email = $email;
        $this->customerIdRequest = new IdRequest($customerId);
    }

    private function createSaveAddressRequest(
        ?string $street,
        ?string $postalCode,
        ?string $city,
        int|string|null $countryId
    ): SaveAddressRequest {
        return new SaveAddressRequest(
            street: (string) $street,
            postalCode: (string) $postalCode,
            city: (string) $city,
            countryId: $countryId,
        );
    }

    /**
     * @param array<int, mixed> $products
     * @return SaveOrderProductRequest[]
     */
    private function createSaveOrderProductRequest(array $products): array
    {
        $saveOrderProductRequestCollection = [];
        foreach ($products as $index => $product) {
            $saveOrderProductRequestCollection[] = new SaveOrderProductRequest(
                productId: $product['productId'] ?? null,
                quantity: $product['quantity'] ?? null, //TODO: Resolve problem with not showing error,
                index: $index
            );
        }
        return $saveOrderProductRequestCollection;
    }


    public static function fromArray(array $data): ArrayHydratableInterface
    {
//        $saveContactDetailsRequest = new SaveContactDetailsRequest(
//            firstname: $data['firstname'] ?? null,
//            surname: $data['surname'] ?? null,
//            phone: $data['phone'] ?? null,
//        );
//
//        $saveAddressDeliveryRequest = new SaveAddressDeliveryRequest(
//            saveAddressRequest: new SaveAddressRequest(
//                street: $data['street'] ?? null,
//                postalCode: $data['postalCode'] ?? null,
//                city: $data['city'] ?? null,
//                countryId: $data['countryId'] ?? null,
//            ),
//            deliveryInstructions: $data['deliveryInstructions'] ?? null,
//        );
//
//        $saveAddressInvoiceRequest = null;
//        $isInvoice = $data['isInvoice'] ?? false;
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
//        $saveOrderProductRequestCollection = [];
//        $saveProductsRequest = $data['products'] ?? [];
//        foreach ($saveProductsRequest as $productRequest) {
//            $saveOrderProductRequestCollection[] = new SaveOrderProductRequest(
//                productId: $productRequest['productId'] ?? null,
//                quantity: $productRequest['quantity'] ?? null,
//            );
//        }
//
//        return new self(
//            saveContactDetailsRequest: $saveContactDetailsRequest,
//            saveAddressDeliveryRequest: $saveAddressDeliveryRequest,
//            paymentMethodId: $data['paymentMethodId'] ?? null,
//            carrierId: $data['carrierId'] ?? null,
//            checkoutStep: $data['checkoutStep'] ?? null,
//            status: $data['status'] ?? null,
//            email: $data['email'] ?? null,
//            isInvoice: $isInvoice,
//            saveAddressInvoiceRequest: $saveAddressInvoiceRequest,
//            saveOrderProductRequestCollection: $saveOrderProductRequestCollection,
//            customerId: $data['customerId'] ?? null,
//        );
    }
}
