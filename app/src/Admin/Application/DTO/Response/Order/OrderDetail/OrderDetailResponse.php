<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailResponse
{
    public function __construct(
        public OrderDetailInformationResponse $information,
        public ?OrderDetailContactResponse $contactDetails = null,
        public ?OrderDetailDeliveryAddressResponse $deliveryAddress = null,
        public ?OrderDetailInvoiceAddressResponse $invoiceAddress = null,
        public ?OrderDetailShippingResponse $shipping = null,
        public ?OrderDetailPaymentResponse $payment = null,
        public ?OrderDetailItemsResponse $items = null,
        public OrderDetailSummaryResponse $summary,
    ) {
    }
}
