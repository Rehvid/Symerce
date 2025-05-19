<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\DeliveryTime;


final readonly class DeliveryTimeListResponse
{
    public function __construct(
        public int $id,
        public string $label,
        public int $minDays,
        public int $maxDays,
        public string $type,
    ) {
    }
}
