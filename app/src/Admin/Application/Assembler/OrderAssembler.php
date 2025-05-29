<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Order\OrderFormResponse;
use App\Admin\Application\DTO\Response\Order\OrderListResponse;
use App\Admin\Application\Factory\Order\OrderDetailResponseFactory;
use App\Admin\Application\Factory\Order\OrderFormContextResponseFactory;
use App\Admin\Domain\ValueObject\DateVO;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Entity\OrderItem;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class OrderAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private MoneyFactory $moneyFactory,
        private TranslatorInterface $translator,
        private OrderDetailResponseFactory $orderDetailResponseFactory,
        private OrderFormContextResponseFactory $orderFormContextResponseFactory,
    ) {}

    /**
     * @param array<int, mixed> $paginatedData
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
            'availableCheckoutSteps' => []
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
        $invoiceAddress = $order->getInvoiceAddress();
        $deliveryAddress = $order->getDeliveryAddress();
        $products = array_map(function (OrderItem $orderItem) {
            return ['productId' => $orderItem->getProduct()->getId(), 'quantity' => $orderItem->getQuantity()];
        }, $order->getOrderItems()->toArray());

        $formDataResponse = new OrderFormResponse(
            checkoutStep: $order->getCheckoutStep()->value,
            status: $order->getStatus()->value,
            uuid: $order->getUuid(),
            carrierId: $order->getCarrier()?->getId(),
            paymentMethodId: $order->getPaymentMethod()?->getId(),
            isInvoice: $invoiceAddress !== null,
            firstname: $order->getContactDetails()?->getFirstname(),
            surname: $order->getContactDetails()?->getSurname(),
            email: $order->getContactDetails()?->getEmail(),
            phone: $order->getContactDetails()?->getPhone(),
            postalCode: $deliveryAddress?->getAddress()->getPostalCode(),
            city: $deliveryAddress?->getAddress()->getCity(),
            street: $deliveryAddress?->getAddress()->getStreet(),
            deliveryInstructions: $deliveryAddress?->getDeliveryInstructions(),
            invoiceStreet: $invoiceAddress?->getAddress()->getStreet(),
            invoiceCity: $invoiceAddress?->getAddress()->getCity(),
            invoicePostalCode: $invoiceAddress?->getAddress()->getPostalCode(),
            companyName: $invoiceAddress?->getCompanyName(),
            companyTaxId: $invoiceAddress?->getCompanyTaxId(),
            products: $products
        );

        return $this->responseHelperAssembler->wrapFormResponse(
            data: $formDataResponse,
            context: $this->orderFormContextResponseFactory->create()
        );
    }


    private function createOrderListResponse(Order $order): OrderListResponse
    {
        $createdAt = $order->getCreatedAt() === null ? null : (new DateVO($order->getCreatedAt()))->formatRaw();
        $updatedAt = $order->getUpdatedAt() === null ? null : (new DateVO($order->getUpdatedAt()))->formatRaw();
        $totalPrice = $order->getTotalPrice() === null ? null : $this->moneyFactory->create($order->getTotalPrice());

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
