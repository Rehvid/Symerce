<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Dto\Response;

final readonly class WarehouseFormResponse
{
    public function __construct(
        public string $name,
        public ?string $description,
        public bool $isActive,
        public string $street,
        public string $postalCode,
        public string $city,
        public int $country,
    ) {}
}
