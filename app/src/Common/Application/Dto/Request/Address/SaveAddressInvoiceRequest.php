<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAddressInvoiceRequest
{
    #[Assert\Valid]
    public SaveAddressRequest $saveAddressRequest;

    #[Assert\When(
        expression: 'this.invoiceCompanyName !== null or this.companyName !== ""',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $invoiceCompanyName;

    #[Assert\When(
        expression: 'this.invoiceCompanyTaxId !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $invoiceCompanyTaxId;

    public function __construct(
        SaveAddressRequest $saveAddressRequest,
        ?string $companyName,
        ?string $companyTaxId
    ) {
        $this->saveAddressRequest = $saveAddressRequest;
        $this->invoiceCompanyName = $companyName;
        $this->invoiceCompanyTaxId = $companyTaxId;
    }
}
