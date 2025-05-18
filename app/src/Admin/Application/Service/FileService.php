<?php

declare(strict_types = 1);

namespace App\Admin\Application\Service;

use App\Admin\Domain\Contract\HasFileInterface;
use App\Admin\Domain\Model\FileData;
use App\Admin\Infrastructure\Service\FileStorageService;
use App\Entity\File;
use App\Repository\FileRepository;

final readonly class FileService
{
    public function __construct(
        private FileStorageService $fileStorageService,
        private FileRepository $repository,
    ) {
    }

    public function addFile(HasFileInterface $entity, FileData $fileData): void
    {
        $currentFile = new File();

        $this->hydrate($entity, $fileData, $currentFile);
    }

    public function replaceFile(HasFileInterface $entity, FileData $fileData): void
    {
        $currentFile = $entity->getFile();
        if ($currentFile !== null) {
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

    private function hydrate(HasFileInterface $entity, FileData $fileData, File $currentFile): void
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
