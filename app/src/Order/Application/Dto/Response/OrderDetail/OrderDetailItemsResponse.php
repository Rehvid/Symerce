<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

use App\Common\Application\Dto\Response\OrderableItemResponse;

final readonly class OrderDetailItemsResponse
{
    /** @param OrderableItemResponse[] $itemCollection */
    public function __construct(
        public array $itemCollection,
    ) {
    }
}
