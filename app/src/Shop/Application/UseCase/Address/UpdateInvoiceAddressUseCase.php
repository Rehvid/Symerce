<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Address;

use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Shop\Application\Hydrator\AddressHydrator;
use App\Shop\Application\Hydrator\InvoiceAddressHydrator;

final readonly class UpdateInvoiceAddressUseCase
{
    public function __construct(
        private AddressHydrator $addressHydrator,
        private InvoiceAddressHydrator $invoiceAddressHydrator
    ) {
    }

    public function execute(SaveAddressInvoiceRequest $request, InvoiceAddress $invoiceAddress): InvoiceAddress
    {
        $invoiceAddress->setAddress($this->addressHydrator->hydrate($request, $invoiceAddress->getAddress()));

        return $this->invoiceAddressHydrator->hydrate($request, $invoiceAddress);
    }
}
