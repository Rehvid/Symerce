<?php

namespace App\DTO\Response\DeliveryTime;

use App\DTO\Response\ResponseInterfaceData;

final readonly class DeliveryTimeIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $label,
        public int $minDays,
        public int $maxDays,
        public string $type,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            label: $data['label'],
            minDays: $data['minDays'],
            maxDays: $data['maxDays'],
            type: $data['type'],
        );
    }
}
