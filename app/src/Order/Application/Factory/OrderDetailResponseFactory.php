<?php

declare(strict_types=1);

namespace App\Order\Application\Factory;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\ValueObject\DateVO;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailAddressResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailContactResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailDeliveryAddressResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailInformationResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailInvoiceAddressResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailItemResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailItemsResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailPaymentItemResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailPaymentResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailShippingResponse;
use App\Order\Application\Dto\Response\OrderDetail\OrderDetailSummaryResponse;
use App\Order\Application\Service\OrderPriceCalculator;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Entity\OrderItem;
use App\Shop\Domain\Entity\Embeddables\Address;
use App\Shop\Domain\Entity\Payment;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class OrderDetailResponseFactory
{
    public function __construct(
        private TranslatorInterface $translator,
        private MoneyFactory $moneyFactory,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
        private OrderPriceCalculator $orderPriceCalculator,
    ) {

    }

    public function fromOrder(Order $order): OrderDetailResponse
    {
        return new OrderDetailResponse(
            information: $this->createOrderDetailInformationResponse($order),
            contactDetails: $this->createOrderDetailContactResponse($order),
            deliveryAddress: $this->createOrderDetailDeliveryAddressResponse($order),
            invoiceAddress: $this->createOrderDetailInvoiceAddressResponse($order),
            shipping: $this->createOrderDetailShippingResponse($order),
            payment: $this->createOrderDetailPaymentResponse($order),
            items : $this->createOrderDetailItemsResponse($order),
            summary: $this->createOrderDetailSummaryResponse($order),
        );
    }

    private function createOrderDetailInformationResponse(Order $order): OrderDetailInformationResponse
    {
        return new OrderDetailInformationResponse(
            id: $order->getId(),
            uuid: $order->getUuid(),
            orderStatus: $this->translator->trans("base.order_status_type.{$order->getStatus()->value}"),
            checkoutStatus: $this->translator->trans("base.checkout_type.{$order->getCheckoutStep()->value}"),
            createdAt: (new DateVO($order->getCreatedAt()))->formatRaw(),
            updatedAt: (new DateVO($order->getUpdatedAt()))->formatRaw(),
        );
    }

    private function createOrderDetailContactResponse(Order $order): ?OrderDetailContactResponse
    {
        $contactDetails = $order->getContactDetails();
        if (null === $contactDetails) {
            return null;
        }

        return new OrderDetailContactResponse(
            firstname: $contactDetails->getFirstname(),
            lastname: $contactDetails->getSurname(),
            phone: $contactDetails->getPhone(),
            email: $order->getEmail(),
        );
    }

    private function createOrderDetailDeliveryAddressResponse(Order $order): ?OrderDetailDeliveryAddressResponse
    {
        $deliveryAddress = $order->getDeliveryAddress();
        if (null === $deliveryAddress) {
            return null;
        }

        return new OrderDetailDeliveryAddressResponse(
            address: $this->createAddress($deliveryAddress->getAddress()),
            deliveryInstructions: $deliveryAddress->getDeliveryInstructions(),
        );
    }

    private function createOrderDetailInvoiceAddressResponse(Order $order): ?OrderDetailInvoiceAddressResponse
    {
        $invoiceAddress = $order->getInvoiceAddress();
        if (null === $invoiceAddress) {
            return null;
        }

        return new OrderDetailInvoiceAddressResponse(
            address: $this->createAddress($invoiceAddress->getAddress()),
            companyTaxId: $invoiceAddress->getCompanyTaxId(),
            companyName: $invoiceAddress->getCompanyName(),
        );
    }

    private function createAddress(Address $address): OrderDetailAddressResponse
    {
        return new OrderDetailAddressResponse(
            street: $address->getStreet(),
            city: $address->getCity(),
            postalCode: $address->getPostalCode(),
            country: $address->getCountry()->getName(),
        );
    }

    private function createOrderDetailShippingResponse(Order $order): ?OrderDetailShippingResponse
    {
        $carrier = $order->getCarrier();
        if (null === $carrier) {
            return null;
        }

        return new OrderDetailShippingResponse(
            name: $carrier->getName(),
            fee: $this->moneyFactory->create($carrier->getFee())->getFormattedAmountWithSymbol()
        );
    }

    private function createOrderDetailPaymentResponse(Order $order): ?OrderDetailPaymentResponse
    {

        return new OrderDetailPaymentResponse(
            paymentsCollection: array_map(
                fn (Payment $payment) => $this->createOrderDetailPaymentItemResponse($payment),
                $order->getPayments()->toArray()
            ),
        );
    }

    private function createOrderDetailPaymentItemResponse(Payment $payment): OrderDetailPaymentItemResponse
    {
        $paidAt = $payment->getPaidAt() === null ? null : (new DateVO($payment->getPaidAt()))->formatRaw();
        $amount = $payment->getAmount() === null ? null : $this->moneyFactory->create($payment->getAmount())->getFormattedAmountWithSymbol();

        return new OrderDetailPaymentItemResponse(
            id: $payment->getId(),
            paymentStatus: $payment->getStatus()->value,
            paidAt: $paidAt,
            amount: $amount,
            gatewayTransactionId: $payment->getGatewayTransactionId(),
            paymentMethodName: $payment->getPaymentMethod()?->getName(),
        );
    }

    private function createOrderDetailItemsResponse(Order $order): ?OrderDetailItemsResponse
    {
        return new OrderDetailItemsResponse(
            itemCollection: array_map(
                fn (OrderItem $orderItem) => $this->createOrderDetailItemResponse($orderItem),
                $order->getOrderItems()->toArray()
            ),
        );
    }

    private function createOrderDetailItemResponse(OrderItem $orderItem): OrderDetailItemResponse
    {
        $product = $orderItem->getProduct();
        $unitPrice = $this->moneyFactory->create($orderItem->getUnitPrice());
        $editUrl = null;
        $imageUrl = null;

        if ($product) {
            $editUrl = $this->urlGenerator->generate(
                'app_admin_react',
                [
                    'reactRoute' => "products/{$product->getId()}/edit"
                ]
            );
            $imageUrl = $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile());
        }


        return new OrderDetailItemResponse(
            name: $product?->getName(),
            imageUrl: $imageUrl ?? null,
            unitPrice: $unitPrice->getFormattedAmountWithSymbol(),
            quantity: $orderItem->getQuantity(),
            totalPrice: $unitPrice->multiply($orderItem->getQuantity())->getFormattedAmountWithSymbol(),
            editUrl: $editUrl ?? null,
        );
    }

    private function createOrderDetailSummaryResponse(Order $order): OrderDetailSummaryResponse
    {
       $orderPriceSummary = $this->orderPriceCalculator->calculatePriceSummary($order);

        return new OrderDetailSummaryResponse(
            summaryProductPrice: $orderPriceSummary?->totalProductPrice?->getFormattedAmountWithSymbol(),
            deliveryFee: $orderPriceSummary?->carrierFee?->getFormattedAmountWithSymbol(),
            paymentMethodFee: $orderPriceSummary?->paymentMethodFee?->getFormattedAmountWithSymbol(),
            totalPrice: $orderPriceSummary?->total?->getFormattedAmountWithSymbol(),
        );
    }
}
