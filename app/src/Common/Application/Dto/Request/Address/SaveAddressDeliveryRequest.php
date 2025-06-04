<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

final readonly class SaveAddressDeliveryRequest
{
    public function __construct(
        public SaveAddressRequest $saveAddressRequest,
        public ?string $deliveryInstructions = null,
    ) {

    }
}
