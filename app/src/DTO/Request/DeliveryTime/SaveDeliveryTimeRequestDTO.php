<?php

namespace App\DTO\Request\DeliveryTime;

use App\Interfaces\PersistableInterface;

class SaveDeliveryTimeRequestDTO implements PersistableInterface
{
    public function __construct(
        public string $label,
        public string $minDays,
        public string $maxDays,
        public string $type
    ) {}
}
