<?php

declare(strict_types=1);

namespace App\Dashboard\Dto\Response;

final readonly class DashboardBestseller
{
    public function __construct(
        public ?string $productImage,
        public string $productName,
        public ?string $mainCategory,
        public bool $isInStock,
        public int $totalSold
    ) {

    }
}
