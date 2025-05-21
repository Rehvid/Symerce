<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Address;

use App\Shared\Domain\Entity\DeliveryAddress;
use App\Shop\Application\DTO\Request\Address\SaveAddressDeliveryRequest;
use App\Shop\Application\Hydrator\AddressHydrator;
use App\Shop\Application\Hydrator\DeliveryAddressHydrator;
use App\Shop\Domain\Entity\Embeddables\Address;

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
