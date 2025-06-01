<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Common\Domain\Entity\InvoiceAddress;
use App\Shared\Application\DTO\Request\Address\SaveAddressInvoiceRequest;

final readonly class InvoiceAddressHydrator
{
    public function hydrate(SaveAddressInvoiceRequest $request, InvoiceAddress $invoiceAddress): InvoiceAddress
    {
        $invoiceAddress->setCompanyTaxId($request->companyTaxId);
        $invoiceAddress->setCompanyName($request->companyName);

        return $invoiceAddress;
    }
}
