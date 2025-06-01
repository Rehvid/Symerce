<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Vendor\VendorFormResponse;
use App\Admin\Application\DTO\Response\Vendor\VendorListResponse;
use App\Common\Domain\Entity\Vendor;

final readonly class VendorAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {}

    public function toListResponse(array $paginatedData): array
    {
        $userListCollection = array_map(
            fn (Vendor $vendor) => $this->createVendorListResponse($vendor),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($userListCollection);
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Vendor $vendor): array
    {
        $file = $vendor->getFile();
        $name = $vendor->getName();

        return $this->responseHelperAssembler->wrapFormResponse(
            new VendorFormResponse(
                name: $name,
                isActive: $vendor->isActive(),
                image: $this->responseHelperAssembler->toFileResponse($file?->getId(), $name, $file?->getPath()),
            )
        );
    }

    private function createVendorListResponse(Vendor $vendor): VendorListResponse
    {
        return new VendorListResponse(
            id: $vendor->getId(),
            name: $vendor->getName(),
            isActive: $vendor->isActive(),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($vendor->getFile()?->getPath()),
        );
    }
}
