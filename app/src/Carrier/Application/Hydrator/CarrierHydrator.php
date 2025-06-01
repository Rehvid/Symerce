<?php

declare(strict_types=1);

namespace App\Carrier\Application\Hydrator;

use App\Admin\Application\DTO\Request\Carrier\SaveCarrierRequest;
use App\Admin\Application\Service\FileService;
use App\Carrier\Application\Dto\CarrierData;
use App\Common\Domain\Entity\Carrier;

final readonly class CarrierHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(CarrierData $data, Carrier $carrier): Carrier
    {
        $carrier->setName($data->name);
        $carrier->setActive($data->isActive);
        $carrier->setFee($data->fee);
        $carrier->setIsExternal($data->isExternal);
        if ($data->isExternal) {
            $carrier->setExternalData($data->externalData);
        } else {
            $carrier->setExternalData(null);
        }

        if ($data->fileData) {
            $this->fileService->replaceFile($carrier, $data->fileData);
        }

        return $carrier;
    }
}
