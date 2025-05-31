<?php

declare (strict_types = 1);

namespace App\Order\Application\Factory;

use App\Admin\Domain\Entity\Country;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderItemData;
use App\Order\Application\Dto\Request\SaveOrderProductRequest;
use App\Order\Application\Dto\Request\SaveOrderRequest;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\DTO\AddressData;
use App\Shared\Application\DTO\ContactDetailsData;
use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;
use App\Shared\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shared\Application\Factory\ValidationExceptionFactory;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class OrderDataFactory
{
    public function __construct(
        public PaymentMethodRepositoryInterface $paymentMethodRepository,
        public CarrierRepositoryInterface $carrierRepository,
        public ProductRepositoryInterface $productRepository,
        public CountryRepositoryInterface $countryRepository,
        public ValidationExceptionFactory $validationExceptionFactory
    ) {

    }

    public function fromRequest(SaveOrderRequest $orderRequest): OrderData
    {
        $carrier = $this->carrierRepository->findById($orderRequest->carrierId);
        if (null === $carrier) {
            $this->validationExceptionFactory->createNotFound('carrier');
        }

        $paymentMethod = $this->paymentMethodRepository->findById($orderRequest->paymentMethodId);
        if (null === $paymentMethod) {
            $this->validationExceptionFactory->createNotFound('paymentMethod');
        }

        $addressDeliveryRequest = $orderRequest->saveAddressDeliveryRequest;
        $addressInvoiceRequest = $orderRequest->saveAddressInvoiceRequest;


        return new OrderData(
            contactDetailsData: $this->createContactDetailsData($orderRequest->saveContactDetailsRequest),
            email: $orderRequest->saveContactDetailsRequest->email,
            carrier: $carrier,
            paymentMethod: $paymentMethod,
            checkoutStep: CheckoutStep::from($orderRequest->checkoutStep),
            orderStatus: OrderStatus::from($orderRequest->status),
            orderItems: $this->getOrderItems($orderRequest->saveOrderProductRequestCollection),
            deliveryAddressData: $this->createDeliveryAddressData($addressDeliveryRequest->saveAddressRequest),
            deliveryInstructions: $addressDeliveryRequest?->deliveryInstructions,
            invoiceAddressData: $orderRequest->saveAddressInvoiceRequest
                ? $this->createInvoiceAddressData($addressInvoiceRequest->saveAddressRequest)
                : null,
            companyTaxId: $addressInvoiceRequest?->companyTaxId,
            companyName: $addressInvoiceRequest?->companyName,
        );
    }

    private function createContactDetailsData(SaveContactDetailsRequest $contactDetailsRequest): ContactDetailsData
    {
        return new ContactDetailsData(
            firstname: $contactDetailsRequest->firstname,
            surname: $contactDetailsRequest->surname,
            phone: $contactDetailsRequest->phone,
        );
    }

    private function createDeliveryAddressData(SaveAddressRequest $addressRequest): AddressData
    {
        $country = $this->countryRepository->findById($addressRequest->country);
        if (null === $country) {
            $this->validationExceptionFactory->createNotFound('country');
        }

        return $this->createAddressData($addressRequest, $country);
    }

    private function createInvoiceAddressData(SaveAddressRequest $invoiceRequest): AddressData
    {
        return $this->createAddressData(
            $invoiceRequest,
            $this->countryRepository->findById($invoiceRequest->country)
        );
    }

    private function createAddressData(SaveAddressRequest $addressRequest, ?Country $country): AddressData
    {
        return new AddressData(
            street: $addressRequest->street,
            postalCode: $addressRequest->postalCode,
            city: $addressRequest->city,
            country: $country,
        );
    }

    /**
     * @param SaveOrderProductRequest[] $saveOrderProductRequestCollection
     * @return OrderItemData[]
     */
    private function getOrderItems(array $saveOrderProductRequestCollection): array
    {
        $orderItems = [];

        foreach ($saveOrderProductRequestCollection as $orderProductRequest) {
            $product = $this->productRepository->findById($orderProductRequest->productId);

            if (null === $product) {
                throw new BadRequestException("Product not found");
            }

            $orderItems[] = new OrderItemData(
                product: $product,
                quantity: (int) $orderProductRequest->quantity,
            );
        }

        return $orderItems;
    }
}
