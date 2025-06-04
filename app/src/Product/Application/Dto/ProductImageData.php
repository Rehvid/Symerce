<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Admin\Domain\Model\FileData;
use App\Common\Domain\Entity\File;

final readonly class ProductImageData
{
    public function __construct(
        public ?File $file,
        public bool $isThumbnail,
        public ?FileData $fileData,
        public int $position,
    ) {}
}
