<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Dto\Response;

final readonly class WarehouseListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $fullAddress,
        public bool $isActive,
    ) {}
}
