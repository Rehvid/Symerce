<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\Entity\Carrier;
use App\Interfaces\PersistableInterface;
use App\Mapper\Interface\RequestToEntityMapperInterface;
use App\Service\FileService;

class CarrierMapper implements RequestToEntityMapperInterface
{

    public function __construct(
        private readonly FileService $fileService,
    )
    {
    }

    public function toNewEntity(PersistableInterface $persistable): Carrier
    {
        return $this->fillEntity(new Carrier(), $persistable);
    }

    public function toExistingEntity(PersistableInterface|SaveCarrierRequestDTO $persistable, object $entity): Carrier
    {
        return $this->fillEntity($entity, $persistable);
    }

    private function fillEntity(Carrier $carrier, PersistableInterface|SaveCarrierRequestDTO $persistable): Carrier
    {
        $carrier->setName($persistable->name);
        $carrier->setActive($persistable->isActive);
        $carrier->setFee($persistable->fee);
        if (!empty($persistable->image)) {
            foreach ($persistable->image as $image) {
                $carrier->setImage($this->fileService->processFileRequestDTO($image, $carrier->getImage()));
            }
        }

        return $carrier;
    }
}
