<?php

declare(strict_types=1);

namespace App\Brand\Application\Assembler;

use App\Brand\Application\Dto\Response\BrandFormResponse;
use App\Brand\Application\Dto\Response\BrandListResponse;
use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\Brand;
use App\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class BrandAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @param array<int,mixed> $paginatedData
     *
     * @return BrandListResponse[]
     */
    public function toListResponse(array $paginatedData): array
    {
        $userListCollection = array_map(
            fn (Brand $vendor) => $this->createVendorListResponse($vendor),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($userListCollection);
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Brand $vendor): array
    {
        $file = $vendor->getFile();
        $name = $vendor->getName();

        return $this->responseHelperAssembler->wrapFormResponse(
            new BrandFormResponse(
                name: $name,
                isActive: $vendor->isActive(),
                thumbnail: $this->responseHelperAssembler->toFileResponse($file?->getId(), $name, $file?->getPath()),
            )
        );
    }

    private function createVendorListResponse(Brand $brand): BrandListResponse
    {
        $brandId = $brand->getId();

        return new BrandListResponse(
            id: $brandId,
            name: $brand->getName(),
            isActive: $brand->isActive(),
            usedInProducts: $this->productRepository->countProductsByBrand($brandId),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($brand->getFile()?->getPath()),
        );
    }
}
