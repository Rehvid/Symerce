<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto;

use App\Admin\Domain\Model\FileData;

final readonly class CarrierData
{
    public function __construct(
        public string $name,
        public ?string $fee,
        public bool $isActive,
        public bool $isExternal,
        public ?array $externalData,
        public ?FileData $fileData,
    ) {}
}
