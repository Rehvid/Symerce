<?php


namespace App\Brand\Application\Factory;

use App\Brand\Application\Dto\BrandData;
use App\Brand\Application\Dto\Request\SaveBrandRequest;

final readonly class BrandDataFactory
{
    public function fromRequest(SaveBrandRequest $brandRequest): BrandData
    {
        return new BrandData(
            name: $brandRequest->name,
            isActive: $brandRequest->isActive,
            fileData: $brandRequest->fileData,
        );
    }
}
