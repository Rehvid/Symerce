<?php

declare (strict_types = 1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\DTO\Request\Product\SaveProductImageRequest;
use App\Admin\Application\Hydrator\FileHydrator;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductImage;
use App\Admin\Domain\Model\FileData;
use App\Admin\Infrastructure\Service\FileStorageService;
use App\Shared\Application\Factory\ValidationExceptionFactory;
use Doctrine\Common\Collections\Collection;

final readonly class ProductImageHydrator
{
    public function __construct(
        private FileStorageService $fileStorageService,
        private FileHydrator $fileHydrator,
        private ValidationExceptionFactory $validationExceptionFactory
    ) {

    }

    public function hydrate(array $imageRequestData, Product $product): void
    {
        $images = $product->getImages();

        /** @var SaveProductImageRequest $imageRequest */
        foreach ($imageRequestData as $position => $imageRequest) {
            $productImage = $this->getProductImage($imageRequest, $images, $product);
            $productImage->setIsThumbnail($imageRequest->isThumbnail);
            $productImage->setOrder($position);
        }
    }

    private function getProductImage(SaveProductImageRequest $imageRequest, Collection $images, Product $product): ProductImage
    {
        if ($imageRequest->fileId) {
            $image = $images->filter(
                fn (ProductImage $image) => $image->getFile()->getId() === $imageRequest->fileId
            )->first();

            if (!$image) {
                $this->validationExceptionFactory->createNotFound('productImage');
            }

            return $image;
        }

         if ($imageRequest->uploadData !== null) {
            return $this->createProductImage($imageRequest->uploadData, $product);
        }


         $this->validationExceptionFactory->createNotFound('productImage');
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
