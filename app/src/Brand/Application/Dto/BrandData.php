<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto;

use App\Admin\Domain\Model\FileData;

final readonly class BrandData
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public ?FileData $fileData,
    ) {}
}
