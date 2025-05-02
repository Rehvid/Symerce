<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\ResponseInterfaceData;
use App\DTO\Response\Vendor\VendorFormResponseDTO;
use App\DTO\Response\Vendor\VendorIndexResponseDTO;
use App\Entity\Vendor;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class VendorResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Vendor $vendor) => $this->createVendorIndexResponse($vendor), $data)
        );
    }

    private function createVendorIndexResponse(Vendor $vendor): ResponseInterfaceData
    {
        return VendorIndexResponseDTO::fromArray([
            'id' => $vendor->getId(),
            'name' => $vendor->getName(),
            'imagePath' => $this->responseMapperHelper->buildPublicFilePath($vendor->getImage()?->getPath()),
            'isActive' => $vendor->isActive(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Vendor $vendor */
        $vendor = $data['entity'];
        $name = $vendor->getName();

        $image = $vendor->getImage();
        $response = VendorFormResponseDTO::fromArray([
            'name' => $vendor->getName(),
            'isActive' => $vendor->isActive(),
            'image' => $this->responseMapperHelper->createFileResponseData(
                $image?->getId(),
                $name,
                $image?->getPath(),
            )]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
