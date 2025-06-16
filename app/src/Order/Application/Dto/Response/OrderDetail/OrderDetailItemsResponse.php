<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailItemsResponse
{
    /** @param OrderDetailItemResponse[] $itemCollection */
    public function __construct(
        public array $itemCollection,
    ) {
    }
}
