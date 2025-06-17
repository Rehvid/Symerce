<?php

declare(strict_types=1);

namespace App\Common\Application\Service;

use App\Common\Application\Dto\FileData;
use App\Common\Domain\Contracts\FileEntityInterface;
use App\Common\Domain\Entity\File;
use App\Common\Domain\Repository\FileRepositoryInterface;
use App\Common\Infrastructure\Service\FileStorageService;

final readonly class FileService
{
    public function __construct(
        private FileStorageService $fileStorageService,
        private FileRepositoryInterface $repository,
    ) {
    }

    public function addFile(FileEntityInterface $entity, FileData $fileData): void
    {
        $currentFile = new File();

        $this->hydrate($entity, $fileData, $currentFile);
    }

    public function replaceFile(FileEntityInterface $entity, FileData $fileData): void
    {
        $currentFile = $entity->getFile();
        if (null !== $currentFile) {
            $this->fileStorageService->removeFile($currentFile->getPath());
        } else {
            $currentFile = new File();
        }

        $this->hydrate($entity, $fileData, $currentFile);
    }

    public function removeFileCompletely(File $file): void
    {
        $this->fileStorageService->removeFile($file->getPath());
        $this->repository->remove($file);
    }

    public function preparePublicPathToFile(?string $filePath): ?string
    {
        return $this->fileStorageService->preparePublicPathToFile($filePath);
    }

    public function getLogoPublicPath(): string
    {
        return $this->fileStorageService->getLogoPublicPath();
    }

    private function hydrate(FileEntityInterface $entity, FileData $fileData, File $currentFile): void
    {
        $path = $this->fileStorageService->saveFile($fileData->content, $fileData->type);

        $currentFile->setPath($path);
        $currentFile->setName(basename($path));
        $currentFile->setOriginalName($fileData->name);
        $currentFile->setMimeType($fileData->type);
        $currentFile->setSize($fileData->size);

        $entity->setFile($currentFile);
    }
}
