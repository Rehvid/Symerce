<?php

declare(strict_types=1);

namespace App\Carrier\Application\Factory;

use App\Carrier\Application\Dto\CarrierData;
use App\Carrier\Application\Dto\Request\SaveCarrierRequest;

final readonly class CarrierDataFactory
{
    public function fromRequest(SaveCarrierRequest $request): CarrierData
    {
        return new CarrierData(
            name: $request->name,
            fee: $request->fee,
            isActive: $request->isActive,
            isExternal: $request->isExternal,
            externalData: $request->externalData,
            fileData: $request->fileData,
        );
    }
}
