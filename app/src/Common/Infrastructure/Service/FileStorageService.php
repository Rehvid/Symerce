<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Service;

use App\Common\Domain\Enums\FileMimeType;
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

        $folderPath = $uploadDirectory.$folder;
        if (!$this->filesystem->exists($folderPath)) {
            $this->filesystem->mkdir($folderPath);
        }

        $fileName = $this->generateFileName($mimeType);
        $fullPath = $folderPath.'/'.$fileName;

        $this->saveFileToPath($fullPath, $content);

        return $folder.'/'.$fileName;
    }

    public function removeFile(string $filePath): void
    {
        $fullPath = $this->getUploadDirectory().$filePath;
        if ($this->filesystem->exists($fullPath)) {
            $this->filesystem->remove($fullPath);
        }
    }

    public function preparePublicPathToFile(?string $filePath): ?string
    {
        $baseUrl = $this->parameterBag->get('app.base_url');
        if (!is_string($baseUrl)) {
            return null;
        }

        return null === $filePath ? null : $baseUrl.'files/'.$filePath;
    }

    public function getLogoPublicPath(): string
    {
        /** @var string $baseUrl */
        $baseUrl = $this->parameterBag->get('app.base_url');

        /** @var string $brandLogoShort */
        $brandLogoShort = $this->parameterBag->get('app.brand_logo_short');

        return $baseUrl.$brandLogoShort;
    }

    private function generateFileName(FileMimeType $mimeType): string
    {
        return bin2hex(random_bytes(16)).'_'.time().'.'.strtolower($mimeType->name);
    }

    private function getUploadDirectory(): string
    {
        $dir = $this->parameterBag->get('kernel.project_dir');
        if (!is_string($dir)) {
            return '';
        }

        return $dir.'/public/files/';
    }

    private function resolveFolderForPath(FileMimeType $mimeType): string
    {
        return match ($mimeType) {
            FileMimeType::JPEG, FileMimeType::PNG, FileMimeType::WEBP => 'images',
            FileMimeType::PDF => 'documents',
        };
    }

    private function saveFileToPath(string $path, string $content): void
    {
        $base64Data = preg_replace('#^data:[a-zA-Z0-9+/-]+;base64,#i', '', $content);
        if (empty($base64Data)) {
            return;
        }
        file_put_contents($path, base64_decode($base64Data));
    }
}
