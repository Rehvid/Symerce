<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Domain\Entity\InvoiceAddress;

final readonly class InvoiceAddressHydrator
{
    public function hydrate(SaveAddressInvoiceRequest $request, InvoiceAddress $invoiceAddress): InvoiceAddress
    {
        $invoiceAddress->setCompanyTaxId($request->companyTaxId);
        $invoiceAddress->setCompanyName($request->companyName);

        return $invoiceAddress;
    }
}
