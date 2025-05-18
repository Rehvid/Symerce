<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler\Helper;

use App\Admin\Application\Service\FileService;
use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class ResponseHelperAssembler
{
    public function __construct(private FileService $fileService)
    {}

    /**
     * @return array<string, mixed>
     */
    public function wrapAsFormData(mixed $data): array
    {
        return ['formData' => $data];
    }

    public function toFileResponse(?int $id, ?string $name, ?string $filePath): ResponseInterfaceData
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
     * @param array<int, mixed>  $dataList
     * @param array<string, mixed> $additionalData
     *
     * @return array<mixed, mixed>
     */
    public function wrapListWithAdditionalData(array $dataList, array $additionalData = []): array
    {
        if (empty($additionalData)) {
            return $dataList;
        }

        return array_merge($dataList, ['additionalData' => $additionalData]);
    }
}
