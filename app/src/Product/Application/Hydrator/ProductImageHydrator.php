<?php

declare (strict_types = 1);

namespace App\Product\Application\Hydrator;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Hydrator\FileHydrator;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductImage;
use App\Common\Infrastructure\Service\FileStorageService;
use App\Product\Application\Dto\ProductImageData;
use Doctrine\Common\Collections\Collection;

final readonly class ProductImageHydrator
{
    public function __construct(
        private FileStorageService $fileStorageService,
        private FileHydrator $fileHydrator,
    ) {

    }

    /** @param ProductImageData[] $imagesData */
    public function hydrate(array $imagesData, Product $product): void
    {
        $images = $product->getImages();

        foreach ($imagesData as $imageData) {
            $productImage = $this->getProductImage($imageData, $images, $product);
            if (null === $productImage) {
                continue;
            }

            $productImage->setIsThumbnail($imageData->isThumbnail);
            $productImage->setPosition($imageData->position);
            $product->addImage($productImage);
        }
    }

    private function getProductImage(ProductImageData $data, Collection $images, Product $product): ?ProductImage
    {
        if ($data->file) {
            $image = $images->filter(
                fn (ProductImage $image) => $image->getFile()->getId() === $data->file->getId()
            )->first();

            if (!$image) {
                return null;
            }

            return $image;
        }

         if ($data->fileData !== null) {
            return $this->createProductImage($data->fileData, $product);
        }

         return null;
    }

    private function createProductImage(FileData $fileData, Product $product): ProductImage
    {
        $file = $this->fileHydrator->hydrate(
            $fileData,
            $this->fileStorageService->saveFile($fileData->content, $fileData->type)
        );

        $productImage = new ProductImage();
        $productImage->setFile($file);
        $productImage->setProduct($product);


        return $productImage;
    }
}
