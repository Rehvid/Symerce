<?php

declare (strict_types = 1);

namespace App\Warehouse\Application\Dto\Response;

final readonly class WarehouseFormContextResponse
{
    public function __construct(
        public array $availableCountries,
    ) {}
}
