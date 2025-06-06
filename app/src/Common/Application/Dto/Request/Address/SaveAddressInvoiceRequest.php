<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAddressInvoiceRequest
{
    public SaveAddressRequest $saveAddressRequest;

    #[Assert\When(
        expression: 'this.companyName !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $companyName;

    #[Assert\When(
        expression: 'this.companyTaxId !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $companyTaxId;

    public function __construct(
        SaveAddressRequest $saveAddressRequest,
        ?string $companyName,
        ?string $companyTaxId
    ) {
        $this->saveAddressRequest = $saveAddressRequest;
        $this->companyName = $companyName;
        $this->companyTaxId = $companyTaxId;
    }
}
