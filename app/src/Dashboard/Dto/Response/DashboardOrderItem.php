<?php

declare(strict_types=1);

namespace App\Dashboard\Dto\Response;

final readonly class DashboardOrderItem
{
    /** @param array<integer, mixed> $products */
    public function __construct(
        public string $customer,
        public array $products,
        public string $total,
        public string $status,
    ) {}
}
