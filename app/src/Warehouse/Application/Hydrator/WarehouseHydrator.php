<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Hydrator;

use App\Common\Domain\Entity\Warehouse;
use App\Shared\Application\Hydrator\AddressHydrator;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class WarehouseHydrator
{
    public function __construct(
        private AddressHydrator $hydrator,
    ) {}

    public function hydrate(WarehouseData $data, ?Warehouse $warehouse = null): Warehouse
    {
        $address = $warehouse?->getAddress();

        $warehouse ??= new Warehouse();
        $warehouse->setDescription($data->description);
        $warehouse->setName($data->name);
        $warehouse->setActive($data->isActive);
        $warehouse->setAddress($this->hydrator->hydrate($data->addressData, $address));

        return $warehouse;
    }
}
