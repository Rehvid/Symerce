<?php

declare(strict_types=1);

namespace App\Common\Application\Hydrator;

use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\File;

final readonly class FileHydrator
{
    public function hydrate(FileData $fileData, string $filePath, ?File $file = null): File
    {
        $file = $file ?? new File();
        $file->setPath($filePath);
        $file->setName(basename($filePath));
        $file->setOriginalName($fileData->name);
        $file->setMimeType($fileData->type);
        $file->setSize($fileData->size);

        return $file;
    }
}
