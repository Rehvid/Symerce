<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Service;

use App\Enums\FileMimeType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

final readonly class FileStorageService
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private Filesystem $filesystem,
    ) {
    }

    public function saveFile(string $content, FileMimeType $mimeType): string
    {
        $uploadDirectory = $this->getUploadDirectory();
        $folder = $this->resolveFolderForPath($mimeType);

        $folderPath = $uploadDirectory . $folder;
        if (!$this->filesystem->exists($folderPath)) {
            $this->filesystem->mkdir($folderPath);
        }

        $fileName = $this->generateFileName($mimeType);
        $fullPath = $folderPath . '/' . $fileName;

        $this->saveFileToPath($fullPath, $content);

        return $folder . '/' . $fileName;
    }

    public function removeFile(string $filePath): void
    {
        $fullPath = $this->getUploadDirectory() . $filePath;
        if ($this->filesystem->exists($fullPath)) {
            $this->filesystem->remove($fullPath);
        }
    }

    public function preparePublicPathToFile(?string $filePath): ?string
    {
        $baseUrl = $this->parameterBag->get('app.base_url');

        return null === $filePath ? null : $baseUrl . 'files/' . $filePath;
    }


    private function generateFileName(FileMimeType $mimeType): string
    {
        return bin2hex(random_bytes(16)) . '_' . time() . '.' . strtolower($mimeType->name);
    }

    private function getUploadDirectory(): string
    {
        $dir = $this->parameterBag->get('kernel.project_dir');
        return $dir . '/public/files/';
    }

    private function resolveFolderForPath(FileMimeType $mimeType): string
    {
        return match ($mimeType) {
            FileMimeType::JPEG, FileMimeType::PNG, FileMimeType::WEBP => 'images',
            FileMimeType::PDF => 'documents',
            default => 'others',
        };
    }

    private function saveFileToPath(string $path, string $content): void
    {
        $base64Data = preg_replace('#^data:[a-zA-Z0-9+/-]+;base64,#i', '', $content);
        file_put_contents($path, base64_decode($base64Data));
    }
}
