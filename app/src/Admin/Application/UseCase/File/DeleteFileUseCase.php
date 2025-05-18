<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\File;

use App\Admin\Application\Service\FileService;
use App\Entity\File;

final readonly class DeleteFileUseCase
{
    public function __construct(
        private FileService $fileService
    ) {

    }

    public function execute(File $file): void
    {
        $this->fileService->removeFileCompletely($file);
    }
}
