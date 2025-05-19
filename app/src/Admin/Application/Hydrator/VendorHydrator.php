<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Vendor\SaveVendorRequest;
use App\Admin\Application\Service\FileService;
use App\Entity\Vendor;

final readonly class VendorHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(SaveVendorRequest $request, Vendor $vendor): Vendor
    {
        $vendor->setName($request->name);
        $vendor->setActive($request->isActive);

        if ($request->fileData) {
            $this->fileService->replaceFile($vendor, $request->fileData);
        }

        return $vendor;
    }
}
