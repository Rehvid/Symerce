<?php

declare (strict_types = 1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\Hydrator\FileHydrator;
use App\Admin\Domain\Entity\File;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductImage;
use App\Admin\Domain\Model\FileData;
use App\Admin\Infrastructure\Service\FileStorageService;

final readonly class ProductImageHydrator
{
    public function __construct(
        private FileStorageService $fileStorageService,
        private FileHydrator $fileHydrator,
    ) {

    }

    public function hydrate(array $imageRequestData, Product $product): void
    {
        $unique = $this->getNewImagesForCreate($imageRequestData, $product);

        foreach ($unique as $imageRequest) {
            $this->handleImageRequest($imageRequest, $product);
        }
    }

    /** @return array<int, mixed> */
    private function getNewImagesForCreate(array $imageRequestData, Product $product): array
    {
        $existingImages = $product->getImages();
        $existingImageIds = $existingImages->map(fn (ProductImage $productImage) => $productImage->getFile()->getId());
        return array_filter($imageRequestData, function ($image) use ($existingImageIds) {
            $id = $image['id'] ?? null;

            return empty($id) || !$existingImageIds->contains($id);
        });
    }

    private function handleImageRequest(array $imageRequest, Product $product): void
    {
        $fileData = FileData::fromArray($imageRequest);
        $file = $this->fileHydrator->hydrate(
            $fileData,
            $this->fileStorageService->saveFile($fileData->content, $fileData->type)
        );
        $this->createProductImage($file, $product);
    }

    private function createProductImage(File $file, Product $product): void
    {
        $productImage = new ProductImage();
        $productImage->setFile($file);
        $productImage->setProduct($product);
        $productImage->setIsThumbnail(false);

        $product->addImage($productImage);
    }
}
