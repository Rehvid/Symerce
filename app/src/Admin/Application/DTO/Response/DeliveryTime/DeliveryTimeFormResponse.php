<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\DeliveryTime;

final readonly class DeliveryTimeFormResponse extends DeliveryTimeCreateFormResponse
{
    public function __construct(
        public ?string $label,
        public ?int $minDays,
        public ?int $maxDays,
        public ?string $type,
        public bool $isActive,
        array $availableTypes,
    ) {
        parent::__construct($availableTypes);
    }
}
