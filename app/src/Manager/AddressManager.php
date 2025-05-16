<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Shop\Request\Address\SaveAddressDeliveryRequest;
use App\DTO\Shop\Request\Address\SaveAddressInvoiceRequest;
use App\DTO\Shop\Request\Address\SaveAddressRequest;
use App\Entity\DeliveryAddress;
use App\Entity\Embeddables\Address;
use App\Entity\InvoiceAddress;

class AddressManager
{
    public function createDeliveryAddress(SaveAddressDeliveryRequest $request): DeliveryAddress
    {
        $addressDelivery = new DeliveryAddress();

        $addressDelivery->setAddress($this->createAddress($request));
        $this->setDeliveryCommonFields($request, $addressDelivery);

        return $addressDelivery;
    }

    public function updateDeliveryAddress(SaveAddressDeliveryRequest $request, DeliveryAddress $deliveryAddress): DeliveryAddress
    {
        $this->setAddressCommonFields($request, $deliveryAddress);

        return $deliveryAddress;
    }

    private function setDeliveryCommonFields(SaveAddressDeliveryRequest $request, DeliveryAddress $deliveryAddress): void
    {
        $deliveryAddress->setDeliveryInstructions($request->deliveryInstructions);
    }

    public function createInvoiceAddress(SaveAddressInvoiceRequest $request): InvoiceAddress
    {
        $addressInvoice = new InvoiceAddress();
        $addressInvoice->setAddress($this->createAddress($request));

        $this->setInvoiceCommonFields($request, $addressInvoice);

        return $addressInvoice;
    }

    public function updateInvoiceAddress(SaveAddressInvoiceRequest $request, InvoiceAddress $addressInvoice): InvoiceAddress
    {
        $this->setAddressCommonFields($request, $addressInvoice->getAddress());
        $this->setInvoiceCommonFields($request, $addressInvoice);

        return $addressInvoice;
    }

    private function setInvoiceCommonFields(SaveAddressInvoiceRequest $request, InvoiceAddress $addressInvoice): void
    {
        $addressInvoice->setCompanyTaxId($request->companyTaxId);
        $addressInvoice->setCompanyName($request->companyName);
    }

    private function createAddress(SaveAddressRequest $request): Address
    {
        $address = new Address();
        $this->setAddressCommonFields($request, $address);

        return $address;
    }

    private function setAddressCommonFields(SaveAddressRequest $request, Address $address): void
    {
        $address->setCity($request->city);
        $address->setStreet($request->street);
        $address->setPostalCode($request->postalCode);
        $address->setCountry($request->country);
    }
}
