<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Customer;

use App\Admin\Application\DTO\Request\Customer\SaveCustomerRequest;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\Hydrator\AddressHydrator;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Entity\DeliveryAddress;
use App\Shared\Domain\Entity\InvoiceAddress;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;
use App\Shop\Application\Hydrator\ContactDetailsHydrator;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UpdateCustomerUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private AddressHydrator $hydrator,
        private ContactDetailsHydrator $contactDetailsHydrator,
    ) {}


    /** @param SaveCustomerRequest $requestDto */
    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->findById($entityId);
        if (null === $customer) {
            throw new EntityNotFoundException();
        }

        $customer->setActive($requestDto->isActive);
        if ($requestDto->password) {
            $customer->setPassword($this->passwordHasher->hashPassword($customer, $requestDto->password));
        }

        $customer->setContactDetails($this->contactDetailsHydrator->hydrate($requestDto->saveContactDetailsRequest));

        if ($requestDto->isDelivery) {
            $deliverySimpleAddress = $customer->getDeliveryAddress()?->getAddress();
            $deliveryAddress = $customer->getDeliveryAddress() ?? new DeliveryAddress();
            $deliveryAddress->setAddress($this->hydrator->hydrate($requestDto->saveAddressDeliveryRequest?->saveAddressRequest, $deliverySimpleAddress));
            $deliveryAddress->setDeliveryInstructions($requestDto->saveAddressDeliveryRequest?->deliveryInstructions);

            $customer->setDeliveryAddress($deliveryAddress);
        }
        if ($requestDto->isInvoice) {
            $invoiceSimpleAddress = $customer->getInvoiceAddress()?->getAddress();
            $invoiceAddress = $customer->getInvoiceAddress() ?? new InvoiceAddress();
            $invoiceAddress->setAddress($this->hydrator->hydrate($requestDto->saveAddressInvoiceRequest?->saveAddressRequest, $invoiceSimpleAddress));
            $invoiceAddress->setCompanyTaxId($requestDto->saveAddressInvoiceRequest?->companyTaxId);
            $invoiceAddress->setCompanyName($requestDto->saveAddressInvoiceRequest?->companyName);

            $customer->setInvoiceAddress($invoiceAddress);
        }


        $this->customerRepository->save($customer);

        return (new IdResponse($customer->getId()))->toArray();
    }
}
