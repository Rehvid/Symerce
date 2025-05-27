<?php

declare(strict_types = 1);

namespace App\Admin\Application\UseCase\Customer;

use App\Admin\Application\DTO\Request\Customer\SaveCustomerRequest;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\Hydrator\AddressHydrator;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Entity\DeliveryAddress;
use App\Shared\Domain\Entity\InvoiceAddress;
use App\Shared\Domain\Enums\CustomerRole;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;
use App\Shop\Application\Hydrator\ContactDetailsHydrator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final readonly class CreateCustomerUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private UserPasswordHasherInterface $passwordHasher,
        private AddressHydrator $hydrator,
        private ContactDetailsHydrator $contactDetailsHydrator,
    ) {}


    /** @param SaveCustomerRequest $requestDto */
    public function execute(RequestDtoInterface $requestDto): mixed
    {
        $customer = new Customer();
        $customer->setRoles([CustomerRole::CUSTOMER]);
        $customer->setActive($requestDto->isActive);
        $customer->setPassword($this->passwordHasher->hashPassword($customer, $requestDto->password));
        $customer->setContactDetails($this->contactDetailsHydrator->hydrate($requestDto->saveContactDetailsRequest));
        if ($requestDto->isDelivery) {
            $deliveryAddress = new DeliveryAddress();
            $deliveryAddress->setAddress($this->hydrator->hydrate($requestDto->saveAddressDeliveryRequest?->saveAddressRequest));
            $deliveryAddress->setDeliveryInstructions($requestDto->saveAddressDeliveryRequest?->deliveryInstructions);

            $customer->setDeliveryAddress($deliveryAddress);
        }
        if ($requestDto->isInvoice) {
            $invoiceAddress = new InvoiceAddress();
            $invoiceAddress->setAddress($this->hydrator->hydrate($requestDto->saveAddressInvoiceRequest?->saveAddressRequest));
            $invoiceAddress->setCompanyTaxId($requestDto->saveAddressInvoiceRequest?->companyTaxId);
            $invoiceAddress->setCompanyName($requestDto->saveAddressInvoiceRequest?->companyName);

            $customer->setInvoiceAddress($invoiceAddress);
        }

        $this->repository->save($customer);
        return (new IdResponse($customer->getId()))->toArray();
    }
}
