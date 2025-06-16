<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\Handler;

use App\Common\Domain\Entity\Customer;
use App\Customer\Application\Command\CreateCustomerCommand;
use App\Customer\Application\Handler\Command\CreateCustomerCommandHandler;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Enums\CustomerRole;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Tests\Unit\Customer\Helper\CustomerDataFactory;
use PHPUnit\Framework\TestCase;

class CreateCustomerCommandHandlerTest extends TestCase
{
    public function testCreatesCustomerAndReturnsId(): void
    {
        $data = CustomerDataFactory::valid();
        $command = new CreateCustomerCommand($data);

        $customerMock = $this->createMock(Customer::class);
        $customerMock->expects($this->once())
            ->method('setRoles')
            ->with([CustomerRole::CUSTOMER->value]);
        $customerMock->method('getId')->willReturn(42);
        $customerMock->method('getRoles')
            ->willReturn([CustomerRole::CUSTOMER->value]);


        $hydratorMock = $this->createMock(CustomerHydrator::class);
        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($data, $this->isInstanceOf(Customer::class))
            ->willReturn($customerMock);


        $repositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with($customerMock);

        $handler = new CreateCustomerCommandHandler($hydratorMock, $repositoryMock);

        $response = $handler->__invoke($command);

        $this->assertSame(42, $response->getId());
        $this->assertSame([CustomerRole::CUSTOMER->value], $customerMock->getRoles());
    }
}
