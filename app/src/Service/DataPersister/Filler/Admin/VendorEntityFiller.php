<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\PersistableInterface;
use App\DTO\Admin\Request\Vendor\SaveVendorRequestDTO;
use App\Entity\Vendor;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;

/**
 * @extends BaseEntityFiller<SaveVendorRequestDTO>
 */
final class VendorEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly FileService $fileService)
    {
    }

    public function toNewEntity(PersistableInterface|SaveVendorRequestDTO $persistable): Vendor
    {
        return $this->fillEntity($persistable, new Vendor());
    }

    /**
     * @param Vendor $entity
     */
    public function toExistingEntity(PersistableInterface|SaveVendorRequestDTO $persistable, object $entity): Vendor
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveVendorRequestDTO::class;
    }

    /**
     * @param Vendor $entity
     */
    protected function fillEntity(PersistableInterface|SaveVendorRequestDTO $persistable, object $entity): Vendor
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
}
