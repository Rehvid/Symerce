<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

final readonly class SaveAddressInvoiceRequest
{

    public function __construct(
        public SaveAddressRequest $saveAddressRequest,
        public ?string $companyName = null,
        public ?string $companyTaxId = null,
    ) {

    }
}
