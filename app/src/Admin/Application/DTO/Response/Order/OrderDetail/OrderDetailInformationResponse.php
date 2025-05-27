<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailInformationResponse
{
    public function __construct(
          public int $id,
          public string $uuid,
          public string $orderStatus,
          public string $checkoutStatus,
          public string $createdAt,
          public string $updatedAt
    ) {}
}
