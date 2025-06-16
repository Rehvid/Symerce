<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAddressDeliveryRequest
{
    #[Assert\Valid]
    public SaveAddressRequest $saveAddressRequest;

    #[Assert\When(
        expression: 'this.deliveryInstructions !== null',
        constraints: [
            new Assert\Length(min: 2),
        ]
    )]
    public ?string $deliveryInstructions;

    public function __construct(
        SaveAddressRequest $saveAddressRequest,
        ?string $deliveryInstructions = null,
    ) {
        $this->saveAddressRequest = $saveAddressRequest;
        $this->deliveryInstructions = $deliveryInstructions;
    }
}
