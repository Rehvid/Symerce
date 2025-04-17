<?php

declare(strict_types=1);

namespace App\DTO\Response\DeliveryTime;

use App\DTO\Response\ResponseInterfaceData;

final readonly class DeliveryTimeFormResponseDTO implements ResponseInterfaceData
{
    /** @param array<int, mixed>  $types */
    private function __construct(
        public ?string $label,
        public ?int $minDays,
        public ?int $maxDays,
        public ?string $type,
        public array $types,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            label: $data['label'] ?? null,
            minDays: $data['minDays'] ?? null,
            maxDays: $data['maxDays'] ?? null,
            type: $data['type'] ?? null,
            types: $data['types'],
        );
    }
}
