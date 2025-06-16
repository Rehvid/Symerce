<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto;

use App\Common\Application\Dto\AddressData;
use App\Common\Application\Dto\ContactDetailsData;

readonly class CustomerData
{
    public function __construct(
        public ContactDetailsData $contactDetailsData,
        public string $email,
        public ?int $id = null,
        public ?string $password = null,
        public ?string $passwordConfirmation  = null,
        public ?AddressData $deliveryAddressData = null,
        public ?string $deliveryInstructions = null,
        public ?AddressData $invoiceAddressData = null,
        public ?string $companyName = null,
        public ?string $companyTaxId = null,
        public bool $isDelivery = false,
        public bool $isInvoice = false,
        public bool $isActive = false,
    ) {

    }
}
