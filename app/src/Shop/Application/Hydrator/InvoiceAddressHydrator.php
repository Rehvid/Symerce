<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Shared\Application\DTO\Request\Address\SaveAddressInvoiceRequest;
use App\Shared\Domain\Entity\InvoiceAddress;

final readonly class InvoiceAddressHydrator
{
    public function hydrate(SaveAddressInvoiceRequest $request, InvoiceAddress $invoiceAddress): InvoiceAddress
    {
        $invoiceAddress->setCompanyTaxId($request->companyTaxId);
        $invoiceAddress->setCompanyName($request->companyName);

        return $invoiceAddress;
    }
}
