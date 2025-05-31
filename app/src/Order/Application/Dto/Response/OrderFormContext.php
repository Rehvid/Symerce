<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response;

final readonly class OrderFormContext
{
    public function __construct(
        public array $availableProducts = [],
        public array $availableStatuses = [],
        public array $availableCheckoutSteps = [],
        public array $availablePaymentMethods = [],
        public array $availableCarriers = [],
        public array $availableCountries = [],
    ) {}
}
