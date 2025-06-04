<?php

declare(strict_types=1);

namespace App\Common\Application\Assembler;

use App\Common\Application\Dto\Response\FileResponse;
use App\Common\Application\Service\FileService;

final readonly class ResponseHelperAssembler
{
    public function __construct(private FileService $fileService)
    {}

    /**
     * @return array<string, mixed>
     */
    public function wrapFormResponse(mixed $data = null, mixed $context = null): array
    {
        if ($data !== null) {
            $response['formData'] = $data;
        }


        if ($context !== null) {
            $response['formContext'] = $context;
        }

        return $response;
    }

    public function toFileResponse(?int $id, ?string $name, ?string $filePath): FileResponse
    {
        return new FileResponse(
            id: $id,
            name: $name,
            preview: $this->fileService->preparePublicPathToFile($filePath),
        );
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
