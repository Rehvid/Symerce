<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Address;

use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Shop\Application\Hydrator\AddressHydrator;
use App\Shop\Application\Hydrator\DeliveryAddressHydrator;

final readonly class CreateDeliveryAddressUseCase
{
    public function __construct(
        private AddressHydrator $addressHydrator,
        private DeliveryAddressHydrator $deliveryAddressHydrator
    ) {
    }

    public function execute(SaveAddressDeliveryRequest $request): DeliveryAddress
    {
        $deliveryAddress = new DeliveryAddress();
        $deliveryAddress->setAddress($this->addressHydrator->hydrate($request, new Address()));

        return $this->deliveryAddressHydrator->hydrate($request, $deliveryAddress);
    }
}
