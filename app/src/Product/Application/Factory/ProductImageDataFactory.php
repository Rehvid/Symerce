<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Common\Domain\Entity\File;
use App\Common\Domain\Repository\FileRepositoryInterface;
use App\Product\Application\Dto\ProductImageData;
use App\Product\Application\Dto\Request\SaveProductImageRequest;

final readonly class ProductImageDataFactory
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
    ) {
    }

    /** @param SaveProductImageRequest[] $images */
    public function createFromArray(array $images): array
    {
        $fileIds = $this->extractFileIds($images);
        $filesById = $this->fetchFilesById($fileIds);

        return $this->mapToProductImageData($images, $filesById);
    }

    /**
     * @param SaveProductImageRequest[] $images
     *
     * @return int[]
     */
    private function extractFileIds(array $images): array
    {
        return array_filter(
            array_map(fn (SaveProductImageRequest $image) => $image->fileId->getId(), $images)
        );
    }

    /**
     * @param int[] $fileIds
     *
     * @return array<int, File>
     */
    private function fetchFilesById(array $fileIds): array
    {
        $files = $this->fileRepository->findBy(['id' => $fileIds]);

        $filesById = [];
        foreach ($files as $file) {
            $filesById[$file->getId()] = $file;
        }

        return $filesById;
    }

    /**
     * @param SaveProductImageRequest[] $images
     * @param array<int, File>          $filesById
     *
     * @return ProductImageData[]
     */
    private function mapToProductImageData(array $images, array $filesById): array
    {
        $result = [];

        foreach ($images as $position => $request) {
            $result[] = new ProductImageData(
                file: $filesById[$request->fileId->getId()] ?? null,
                isThumbnail: $request->isThumbnail,
                fileData: $request->uploadData,
                position: $position
            );
        }

        return $result;
    }
}
