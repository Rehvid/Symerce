<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailItemsResponse
{
    /** @param OrderDetailItemResponse[] $itemCollection */
    public function __construct(
        public array $itemCollection,
    ) {}
}
