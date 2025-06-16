<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\Hydrator;

use App\Common\Application\Hydrator\ContactDetailsHydrator;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\ContactDetails;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Common\Application\Hydrator\AddressHydrator;
use App\Tests\Unit\Customer\Helper\CustomerDataFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerHydratorTest extends TestCase
{
    private UserPasswordHasherInterface $passwordHasher;
    private AddressHydrator $addressHydrator;
    private ContactDetailsHydrator $contactDetailsHydrator;
    private CustomerHydrator $customerHydrator;

    protected function setUp(): void
    {
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->passwordHasher
            ->method('hashPassword')
            ->willReturnCallback(fn($user, $password) => 'hashed_' . $password);

        $this->addressHydrator = $this->createMock(AddressHydrator::class);
        $this->addressHydrator
            ->method('hydrate')
            ->willReturnCallback(fn($data, $entity) => $entity);

        $this->contactDetailsHydrator = $this->getMockBuilder(ContactDetailsHydrator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['hydrate'])
            ->getMock();
        $this->contactDetailsHydrator
            ->method('hydrate')
            ->willReturnCallback(fn($data, ContactDetails $cd) => $cd);

        $this->customerHydrator = new CustomerHydrator(
            $this->passwordHasher,
            $this->addressHydrator,
            $this->contactDetailsHydrator
        );
    }

    public function testHydrateSetsBasicDataAndHashesPassword(): void
    {
        $data = CustomerDataFactory::valid();
        $customer = new Customer();

        $customer->setContactDetails(new ContactDetails());

        $result = $this->customerHydrator->hydrate($data, $customer);

        $this->assertSame($customer, $result);
        $this->assertSame($data->email, $result->getEmail());
        $this->assertSame($data->isActive, $result->isActive());

        if ($data->password !== null) {
            $this->assertStringStartsWith('hashed_', $result->getPassword());
        }

        $this->assertNotNull($result->getContactDetails());
        $this->assertInstanceOf(ContactDetails::class, $result->getContactDetails());
    }

    public function testDoesNotHashWhenPasswordIsNull(): void
    {
        $data = CustomerDataFactory::withEmptyPassword();
        $customer = new Customer();
        $customer->setContactDetails(new ContactDetails());

        $this->passwordHasher
            ->expects($this->never())
            ->method('hashPassword');

        $result = $this->customerHydrator->hydrate($data, $customer);
        $this->assertNull($result->getPassword());
    }


    public function testSkipsDeliveryAddressWhenIsDeliveryFalse(): void
    {
        $data = CustomerDataFactory::withoutDelivery();
        $customer = new Customer();
        $customer->setContactDetails(new ContactDetails());

        $result = $this->customerHydrator->hydrate($data, $customer);
        $this->assertNull($result->getDeliveryAddress());
    }

    public function testHydratesDeliveryAddressWhenIsDeliveryTrue(): void
    {
        $data = CustomerDataFactory::withoutInvoice();

        $customer = new Customer();
        $customer->setContactDetails(new ContactDetails());

        $this->addressHydrator
            ->expects($this->once())
            ->method('hydrate')
            ->with(
                $this->identicalTo($data->deliveryAddressData),
                $this->isInstanceOf(Address::class)
            )
            ->willReturnCallback(fn($dto, $addr) => $addr);

        $result = $this->customerHydrator->hydrate($data, $customer);
        $delivery = $result->getDeliveryAddress();
        $this->assertInstanceOf(DeliveryAddress::class, $delivery);
        $this->assertSame('Leave at the door.', $delivery->getDeliveryInstructions());
        $this->assertInstanceOf(Address::class, $delivery->getAddress());
    }


}
