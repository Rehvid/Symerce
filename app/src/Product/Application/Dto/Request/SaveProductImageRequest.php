<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Common\Application\Dto\FileData;

final readonly class SaveProductImageRequest
{
    public function __construct(
        public int|string|null $fileId = null,
        public bool $isThumbnail = false,
        public ?FileData $uploadData = null,
    ) {

    }
}
