<?php

declare (strict_types = 1);

namespace App\Order\Application\Dto;

use App\Admin\Domain\Entity\Carrier;
use App\Admin\Domain\Entity\PaymentMethod;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\Shared\Application\DTO\AddressData;
use App\Shared\Application\DTO\ContactDetailsData;

final readonly class OrderData
{

    /** @param OrderItemData[] $orderItems */
    public function __construct(
        public ContactDetailsData $contactDetailsData,
        public string $email,
        public Carrier $carrier,
        public PaymentMethod $paymentMethod,
        public CheckoutStep $checkoutStep,
        public OrderStatus $orderStatus,
        public array $orderItems,
        public AddressData $deliveryAddressData,
        public ?string $deliveryInstructions,
        public ?AddressData $invoiceAddressData,
        public ?string $companyTaxId,
        public ?string $companyName,

    ){

    }
}
