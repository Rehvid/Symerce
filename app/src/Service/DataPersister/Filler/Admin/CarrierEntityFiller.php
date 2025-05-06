<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\Carrier\SaveCarrierRequestDTO;
use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\Carrier;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;

/**
 * @extends BaseEntityFiller<SaveCarrierRequestDTO>
 */
final class CarrierEntityFiller extends BaseEntityFiller
{
    public function __construct(
        private readonly FileService $fileService
    ) {
    }

    public function toNewEntity(PersistableInterface|SaveCarrierRequestDTO $persistable): Carrier
    {
        return $this->fillEntity($persistable, new Carrier());
    }

    /**
     * @param Carrier $entity
     */
    public function toExistingEntity(PersistableInterface|SaveCarrierRequestDTO $persistable, object $entity): Carrier
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveCarrierRequestDTO::class;
    }

    /**
     * @param Carrier $entity
     */
    protected function fillEntity(PersistableInterface|SaveCarrierRequestDTO $persistable, object $entity): Carrier
    {
        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setFee($persistable->fee);

        if (!empty($persistable->image)) {
            foreach ($persistable->image as $image) {
                $entity->setImage($this->fileService->processFileRequestDTO($image, $entity->getImage()));
            }
        }

        return $entity;
    }
}
