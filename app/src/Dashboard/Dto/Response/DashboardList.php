<?php

declare(strict_types=1);

namespace App\Dashboard\Dto\Response;

final readonly class DashboardList
{
    /**
     * @param DashboardOrderItem[] $orders
     *
     */
    public function __construct(
        public int $customersCount,
        public int $ordersCount,
        public int $productsCount,
        public int $activeCartsCount,
        public array $orders,
        public array $bestSellers,
    ) {

    }
}
