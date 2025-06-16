<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Dto;

use App\Common\Application\Dto\AddressData;

final readonly class WarehouseData
{
    public function __construct(
        public AddressData $addressData,
        public string $name,
        public bool $isActive,
        public ?string $description
    ) {
    }
}
