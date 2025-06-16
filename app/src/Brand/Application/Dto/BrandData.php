<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto;

use App\Common\Application\Dto\FileData;

final readonly class BrandData
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public ?FileData $fileData,
    ) {
    }
}
