<?php

declare(strict_types=1);

namespace App\Service;

use App\Admin\Domain\Enums\FileMimeType;
use App\DTO\Admin\Request\FileRequestDTO;
use App\Entity\File;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class FileService
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private Filesystem $filesystem,
    ) {

    }

    public function processFileRequestDTO(FileRequestDTO $fileRequestDTO, ?File $currentFile): File
    {
        $file = $this->saveFile($currentFile ?? new File(), $fileRequestDTO);
        $this->processFileUpload($file, $fileRequestDTO);

        return $file;
    }

    public function removeFile(File $file): void
    {
        $path = $this->getUploadDirectory().$file->getPath();
        $this->filesystem->remove($path);
    }

    public function preparePublicPathToFile(?string $filePath): ?string
    {
        /** @var string $baseUrl */
        $baseUrl = $this->parameterBag->get('app.base_url');

        return null === $filePath
            ? null
            : $baseUrl.'files/'.$filePath
        ;
    }

    public function getLogoPublicPath(): string
    {
        /** @var string $baseUrl */
        $baseUrl = $this->parameterBag->get('app.base_url');

        /** @var string $brandLogoShort */
        $brandLogoShort = $this->parameterBag->get('app.brand_logo_short');

        return $baseUrl.$brandLogoShort;
    }

    private function processFileUpload(File $file, FileRequestDTO $fileRequestDTO): void
    {
        $uploadDirectory = $this->getUploadDirectory();
        $folderPath = $uploadDirectory.$this->resolveFolderForPath($file->getMimeType());

        if (!$this->filesystem->exists($folderPath)) {
            $this->filesystem->mkdir($folderPath);
        }

        $path = $uploadDirectory.'/'.$file->getPath();
        $this->saveFileToPath($path, $fileRequestDTO->content);
    }

    private function generateFileName(FileMimeType $mimeType): string
    {
        return bin2hex(random_bytes(16)).'_'.time().'.'.strtolower($mimeType->name);
    }

    private function getUploadDirectory(): string
    {
        /** @var string $dir */
        $dir = $this->parameterBag->get('kernel.project_dir');

        return $dir.'/public/files/';
    }

    private function resolveFolderForPath(FileMimeType $fileMimeType): string
    {
        return match ($fileMimeType) {
            FileMimeType::JPEG, FileMimeType::PNG, FileMimeType::WEBP => 'images',
            FileMimeType::PDF => 'documents'
        };
    }

    private function saveFileToPath(string $path, string $content): void
    {
        /** @var string $base64Image */
        $base64Image = preg_replace('#^data:[a-zA-Z0-9+/-]+;base64,#i', '', $content);
        file_put_contents($path, base64_decode($base64Image));
    }

    private function saveFile(File $file, FileRequestDTO $fileRequestDTO): File
    {
        $fileName = $this->generateFileName($fileRequestDTO->type);
        $path =  $this->resolveFolderForPath($fileRequestDTO->type).'/'.$fileName;

        $file->setName($fileName);
        $file->setPath($path);
        $file->setOriginalName($fileRequestDTO->name);
        $file->setMimeType($fileRequestDTO->type);
        $file->setSize($fileRequestDTO->size);

        return $file;
    }
}
