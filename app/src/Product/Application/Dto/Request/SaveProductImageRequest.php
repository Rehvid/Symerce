<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Common\Application\Dto\FileData;

final readonly class SaveProductImageRequest
{
    public int|string|null $fileId;

    public bool $isThumbnail;

    public ?FileData $uploadData;

    public function __construct(
        int|string|null $fileId = null,
        bool $isThumbnail = false,
        ?FileData $uploadData = null,
    ) {
        $this->fileId = $fileId;
        $this->isThumbnail = $isThumbnail;
        $this->uploadData = $uploadData;
    }
}
