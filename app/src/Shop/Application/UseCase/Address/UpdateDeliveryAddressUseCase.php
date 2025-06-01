<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Address;

use App\Common\Domain\Entity\DeliveryAddress;
use App\Shared\Application\DTO\Request\Address\SaveAddressDeliveryRequest;
use App\Shop\Application\Hydrator\AddressHydrator;
use App\Shop\Application\Hydrator\DeliveryAddressHydrator;

final readonly class UpdateDeliveryAddressUseCase
{
    public function __construct(
        private AddressHydrator $addressHydrator,
        private DeliveryAddressHydrator $deliveryAddressHydrator
    ) {
    }

    public function execute(SaveAddressDeliveryRequest $request, DeliveryAddress $deliveryAddress): DeliveryAddress
    {
        $this->addressHydrator->hydrate($request, $deliveryAddress);

        return $this->deliveryAddressHydrator->hydrate($request, $deliveryAddress);
    }
}
