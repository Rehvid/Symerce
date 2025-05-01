<?php

declare(strict_types=1);

namespace App\Mapper\Helper;

use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Service\FileService;

final readonly class ResponseMapperHelper
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * @return array<string, ResponseInterfaceData>
     */
    public function prepareFormDataResponse(ResponseInterfaceData $data): array
    {
        return ['formData' => $data];
    }

    public function createFileResponseData(?int $id, ?string $name, ?string $filePath): ResponseInterfaceData
    {
        return FileResponseDTO::fromArray([
            'id' => $id,
            'name' => $name,
            'preview' => $this->fileService->preparePublicPathToFile($filePath),
        ]);
    }

    public function buildPublicFilePath(?string $filePath): ?string
    {
        return $this->fileService->preparePublicPathToFile($filePath);
    }

    /**
     * @param array<int, mixed>    $dataIndex
     * @param array<string, mixed> $additionalData
     *
     * @return array<mixed, mixed>
     */
    public function prepareIndexFormDataResponse(array $dataIndex, array $additionalData = []): array
    {
        if (empty($additionalData)) {
            return $dataIndex;
        }

        return array_merge($dataIndex, ['additionalData' => $additionalData]);
    }
}
