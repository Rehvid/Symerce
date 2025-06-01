<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Domain\Model\FileData;
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
