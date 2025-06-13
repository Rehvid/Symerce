<?php

declare (strict_types = 1);

namespace App\Order\Application\Factory;

use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Dto\AddressData;
use App\Common\Application\Dto\ContactDetailsData;
use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Application\Dto\Request\ContactDetails\SaveContactDetailsRequest;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderItemData;
use App\Order\Application\Dto\Request\SaveOrderProductRequest;
use App\Order\Application\Dto\Request\SaveOrderRequest;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class OrderDataFactory
{
    public function __construct(
        public PaymentMethodRepositoryInterface $paymentMethodRepository,
        public CarrierRepositoryInterface $carrierRepository,
        public ProductRepositoryInterface $productRepository,
        public CountryRepositoryInterface $countryRepository,
    ) {

    }

    public function fromRequest(SaveOrderRequest $orderRequest): OrderData
    {
        /** @var ?Carrier $carrier */
        $carrier = $this->carrierRepository->findById($orderRequest->carrierId);
        if (null === $carrier) {
            throw EntityNotFoundException::for(Carrier::class, $orderRequest->carrierId);
        }

        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $this->paymentMethodRepository->findById($orderRequest->paymentMethodId);
        if (null === $paymentMethod) {
            throw EntityNotFoundException::for(PaymentMethod::class, $orderRequest->paymentMethodId);
        }

        $addressDeliveryRequest = $orderRequest->saveAddressDeliveryRequest;
        $addressInvoiceRequest = $orderRequest->saveAddressInvoiceRequest;


        return new OrderData(
            contactDetailsData: $this->createContactDetailsData($orderRequest->saveContactDetailsRequest),
            email: $orderRequest->email,
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
        /** @var ?Country $country */
        $country = $this->countryRepository->findById($addressRequest->countryId);
        if (null === $country) {
            throw EntityNotFoundException::for(Country::class, $addressRequest->countryId);
        }

        return $this->createAddressData($addressRequest, $country);
    }

    private function createInvoiceAddressData(SaveAddressRequest $invoiceRequest): AddressData
    {
        return $this->createAddressData(
            $invoiceRequest,
            $this->countryRepository->findById($invoiceRequest->countryId)
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
            /** @var ?Product $product */
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
