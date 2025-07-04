<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Hydrator;

use App\Common\Application\Hydrator\AddressHydrator;
use App\Common\Domain\Entity\Warehouse;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class WarehouseHydrator
{
    public function __construct(private AddressHydrator $hydrator)
    {
    }

    public function hydrate(WarehouseData $data, Warehouse $warehouse): Warehouse
    {
        $address = $warehouse->getAddress();

        $warehouse->setDescription($data->description);
        $warehouse->setName($data->name);
        $warehouse->setActive($data->isActive);
        $warehouse->setAddress($this->hydrator->hydrate($data->addressData, $address));

        return $warehouse;
    }
}
