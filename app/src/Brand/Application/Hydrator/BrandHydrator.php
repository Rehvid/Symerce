<?php

declare(strict_types=1);

namespace App\Brand\Application\Hydrator;

use App\Admin\Application\Service\FileService;
use App\Brand\Application\Dto\BrandData;
use App\Common\Domain\Entity\Brand;

final readonly class BrandHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(BrandData $data, ?Brand $brand = null): Brand
    {
        $brand ??= new Brand();
        $brand->setName($data->name);
        $brand->setActive($data->isActive);

        if ($data->fileData) {
            $this->fileService->replaceFile($brand, $data->fileData);
        }

        return $brand;
    }
}
