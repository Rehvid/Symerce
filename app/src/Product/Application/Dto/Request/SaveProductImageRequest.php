<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Admin\Domain\Model\FileData;

final readonly class SaveProductImageRequest
{
    public function __construct(
        public int|string|null $fileId = null,
        public bool $isThumbnail = false,
        public ?FileData $uploadData = null,
    ) {

    }
}
