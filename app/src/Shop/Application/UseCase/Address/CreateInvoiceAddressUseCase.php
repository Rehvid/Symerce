<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Address;

use App\Common\Application\Dto\Request\Address\SaveAddressInvoiceRequest;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Shop\Application\Hydrator\AddressHydrator;
use App\Shop\Application\Hydrator\InvoiceAddressHydrator;

final readonly class CreateInvoiceAddressUseCase
{
    public function __construct(
        private AddressHydrator $addressHydrator,
        private InvoiceAddressHydrator $invoiceAddressHydrator
    ) {
    }

    public function execute(SaveAddressInvoiceRequest $request): InvoiceAddress
    {
        $invoiceAddress = new InvoiceAddress();
        $invoiceAddress->setAddress($this->addressHydrator->hydrate($request, new Address()));

        return $this->invoiceAddressHydrator->hydrate($request, $invoiceAddress);
    }
}
