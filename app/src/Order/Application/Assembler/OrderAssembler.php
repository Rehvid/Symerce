<?php

declare(strict_types=1);

namespace App\Order\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Domain\ValueObject\DateVO;
use App\Common\Domain\Entity\Order;
use App\Order\Application\Dto\Response\OrderListResponse;
use App\Order\Application\Factory\OrderDetailResponseFactory;
use App\Order\Application\Factory\OrderFormContextResponseFactory;
use App\Order\Application\Factory\OrderFormResponseFactory;
use App\Shared\Application\Factory\MoneyFactory;
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
        return $this->responseHelperAssembler->wrapFormResponse(
            data: $this->orderFormResponseFactory->fromOrder($order),
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
