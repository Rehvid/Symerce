<?php

declare(strict_types=1);

namespace App\Service;

use App\Admin\Domain\Enums\FileMimeType;
use App\DTO\Admin\Request\FileRequestDTO;
use App\Entity\File;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

/** @deprecated  use FileService from Shared */
readonly class FileService
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private Filesystem $filesystem,
    ) {

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
}
