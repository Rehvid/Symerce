<?php

declare (strict_types = 1);

namespace App\Customer\Application\Hydrator;

use App\Common\Application\Hydrator\AddressHydrator;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Customer\Application\Dto\CustomerData;
use App\Shop\Application\Hydrator\ContactDetailsHydrator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CustomerHydrator
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private AddressHydrator $addressHydrator,
        private ContactDetailsHydrator $contactDetailsHydrator,
    ) {}

    public function hydrate(CustomerData $data, ?Customer $customer = null): Customer
    {
        $customer ??= new Customer();

        if (null !== $data->password) {
            $customer->setPassword($this->passwordHasher->hashPassword($customer, $data->password));
        }

        $customer->setEmail($data->email);
        $customer->setActive($data->isActive);
        $customer->setContactDetails(
            $this->contactDetailsHydrator->hydrate($data->contactDetailsData, $customer->getContactDetails())
        );

        $this->hydrateDeliveryAddress($data, $customer);
        $this->hydrateInvoiceAddress($data, $customer);

        return $customer;
    }

    private function hydrateDeliveryAddress(CustomerData $data, Customer $customer): void
    {
        if (!$data->isDelivery) {
            $customer->setDeliveryAddress(null);
            return;
        }

        $deliveryAddress = $customer->getDeliveryAddress() ?? new DeliveryAddress();

        $deliveryAddress->setAddress(
            $this->addressHydrator->hydrate($data->deliveryAddressData,  $deliveryAddress?->getAddress())
        );
        $deliveryAddress->setDeliveryInstructions($data?->deliveryInstructions);

        $customer->setDeliveryAddress($deliveryAddress);
    }

    private function hydrateInvoiceAddress(CustomerData $data, Customer $customer): void
    {
        if (!$data->isInvoice) {
            $customer->setInvoiceAddress(null);
            return;
        }

        $invoiceAddress = $customer->getInvoiceAddress() ?? new InvoiceAddress();

        $invoiceAddress->setAddress(
            $this->addressHydrator->hydrate($data->invoiceAddressData, $invoiceAddress?->getAddress())
        );
        $invoiceAddress->setCompanyTaxId($data?->companyTaxId);
        $invoiceAddress->setCompanyName($data?->companyName);

        $customer->setInvoiceAddress($invoiceAddress);
    }
}
