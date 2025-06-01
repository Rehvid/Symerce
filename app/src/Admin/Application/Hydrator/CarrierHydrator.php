<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Carrier\SaveCarrierRequest;
use App\Admin\Application\Service\FileService;
use App\Common\Domain\Entity\Carrier;

final readonly class CarrierHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(SaveCarrierRequest $request, Carrier $carrier): Carrier
    {
        $carrier->setName($request->name);
        $carrier->setActive($request->isActive);
        $carrier->setFee($request->fee);

        if ($request->fileData) {
            $this->fileService->replaceFile($carrier, $request->fileData);
        }

        return $carrier;
    }
}
