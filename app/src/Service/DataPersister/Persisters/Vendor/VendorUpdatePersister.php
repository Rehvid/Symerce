<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Vendor;

use App\DTO\Request\Vendor\VendorSaveRequestDTO;
use App\Entity\Vendor;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;

class VendorUpdatePersister extends UpdatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private FileService $fileService,
    )
    {
        parent::__construct($entityManager);
    }

    /**
     * @param VendorSaveRequestDTO $persistable
     * @param Vendor $entity;
     * @return Vendor;
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setActive($persistable->isActive);
        $entity->setName($persistable->name);
        if (!empty($persistable->image)) {
            foreach ($persistable->image as $file) {
                $entity->setImage($this->fileService->processFileRequestDTO($file, $entity->getImage()));
            }
        }

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [Vendor::class, VendorSaveRequestDTO::class];
    }
}
