<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Vendor;

use App\DTO\Request\Vendor\VendorSaveRequestDTO;
use App\Entity\Vendor;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;

class VendorCreatePersister extends CreatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private FileService $fileService,
    )
    {
        parent::__construct($entityManager);
    }


    /** @param VendorSaveRequestDTO $persistable */
    protected function createEntity(PersistableInterface $persistable): object
    {
        $vendor = new Vendor();
        $vendor->setActive($persistable->isActive);
        $vendor->setName($persistable->name);
        if (!empty($persistable->image)) {
            foreach ($persistable->image as $file) {
                $vendor->setImage($this->fileService->processFileRequestDTO($file, $vendor->getImage()));
            }
        }

        return $vendor;
    }

    public function getSupportedClasses(): array
    {
        return [VendorSaveRequestDTO::class];
    }
}
