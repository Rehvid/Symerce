<?php

declare(strict_types=1);

namespace App\Order\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\ValueObject\DateVO;
use App\Order\Application\Dto\Response\OrderListResponse;
use App\Order\Application\Dto\Response\OrderSelectedCustomerDataResponse;
use App\Order\Application\Factory\OrderDetailResponseFactory;
use App\Order\Application\Factory\OrderFormContextResponseFactory;
use App\Order\Application\Factory\OrderFormResponseFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class OrderAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private MoneyFactory $moneyFactory,
        private TranslatorInterface $translator,
        private OrderDetailResponseFactory $orderDetailResponseFactory,
        private OrderFormContextResponseFactory $orderFormContextResponseFactory,
        private OrderFormResponseFactory $orderFormResponseFactory,
    ) {
    }

    /**
     * @param array<int, mixed> $paginatedData
     *
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $orderListCollection = array_map(
            fn (Order $order) => $this->createOrderListResponse($order),
            $paginatedData
        );

        $additionalData = [
            'availableStatuses' => [],
            'availableCheckoutSteps' => [],
        ];

        return $this->responseHelperAssembler->wrapListWithAdditionalData($orderListCollection, $additionalData);
    }

    public function toDetailResponse(Order $order): array
    {
        return ['data' => $this->orderDetailResponseFactory->fromOrder($order)];
    }

    public function toCreateFormResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            context: $this->orderFormContextResponseFactory->create()
        );
    }

    public function toFormDataResponse(Order $order): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            data: $this->orderFormResponseFactory->fromOrder($order),
            context: $this->orderFormContextResponseFactory->create()
        );
    }

    public function toCustomerOrderData(Customer $customer): array
    {

        return [
            'data' => new OrderSelectedCustomerDataResponse(
                email: $customer->getEmail(),
                firstname: $customer->getContactDetails()?->getFirstname() ?? '',
                surname: $customer->getContactDetails()?->getSurname() ?? '',
                phone: $customer->getContactDetails()?->getPhone() ?? '',
                postalCode: $customer->getDeliveryAddress()?->getAddress()?->getPostalCode() ?? '',
                street: $customer->getDeliveryAddress()?->getAddress()?->getStreet() ?? '',
                city: $customer->getDeliveryAddress()?->getAddress()?->getCity() ?? '',
                countryId: $customer->getDeliveryAddress()?->getAddress()?->getCountry()->getId() ?? 0,
                deliveryInstructions: $customer->getDeliveryAddress()?->getDeliveryInstructions() ?? '',
                isInvoice: null !== $customer->getInvoiceAddress(),
                invoiceStreet: $customer->getInvoiceAddress()?->getAddress()?->getStreet() ?? '',
                invoiceCompanyName: $customer->getInvoiceAddress()?->getCompanyName() ?? '',
                invoicePostalCode: $customer->getInvoiceAddress()?->getAddress()?->getPostalCode() ?? '',
                invoiceCompanyTaxId: $customer->getInvoiceAddress()?->getCompanyTaxId() ?? '',
                invoiceCountryId: $customer->getInvoiceAddress()?->getAddress()?->getCountry()->getId() ?? 0,
                invoiceCity: $customer->getInvoiceAddress()?->getAddress()?->getCity() ?? ''
            ),
        ];
    }

    private function createOrderListResponse(Order $order): OrderListResponse
    {
        $createdAt =  (new DateVO($order->getCreatedAt()))->formatRaw();
        $updatedAt =  (new DateVO($order->getUpdatedAt()))->formatRaw();
        $totalPrice = null === $order->getTotalPrice() ? null : $this->moneyFactory->create($order->getTotalPrice());

        return new OrderListResponse(
            id: $order->getId(),
            checkoutStep: $this->translator->trans("base.checkout_type.{$order->getCheckoutStep()->value}"),
            status: $this->translator->trans("base.order_status_type.{$order->getStatus()->value}"),
            totalPrice: $totalPrice,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }
}
