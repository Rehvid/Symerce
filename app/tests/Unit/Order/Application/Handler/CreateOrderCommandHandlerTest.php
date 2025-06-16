<?php

declare(strict_types=1);

namespace App\Tests\Unit\Order\Application\Handler;

use App\Common\Domain\Entity\Order;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Application\Handler\Command\CreateOrderCommandHandler;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Application\Mapper\OrderDataToCustomerDataMapper;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Tests\Unit\Order\Application\Helper\OrderDataFactory;
use PHPUnit\Framework\TestCase;

final class CreateOrderCommandHandlerTest extends TestCase
{
    private OrderRepositoryInterface $orderRepository;

    private OrderHydrator $orderHydrator;

    private CustomerRepositoryInterface $customerRepository;

    private CustomerHydrator $customerHydrator;

    private OrderDataToCustomerDataMapper $customerDataMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->orderHydrator = $this->createMock(OrderHydrator::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->customerHydrator = $this->createMock(CustomerHydrator::class);
        $this->customerDataMapper = $this->createMock(OrderDataToCustomerDataMapper::class);
    }

    public function testCreatesOrderForGuestAndReturnsId(): void
    {
        $orderId = 20;

        $data = OrderDataFactory::validForGuest();
        $command = new CreateOrderCommand($data);

        $orderMock = $this->createMock(Order::class);
        $orderMock
            ->method('getId')
            ->willReturn($orderId);

        $this->orderHydrator
            ->expects($this->once())
            ->method('hydrate')
            ->with(
                $this->identicalTo($data),
                $this->isInstanceOf(Order::class)
            )
            ->willReturn($orderMock);

        $this->orderRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->identicalTo($orderMock));

        $handler = new CreateOrderCommandHandler(
            hydrator:           $this->orderHydrator,
            repository:          $this->orderRepository,
            customerRepository:  $this->customerRepository,
            customerHydrator:    $this->customerHydrator,
            customerDataMapper:  $this->customerDataMapper,
        );

        $response = $handler->__invoke($command);
        $this->assertSame($orderId, $response->getId());
    }

    public function testCreatesOrderForCustomerAndReturnsId(): void
    {
        $orderId = 34;

        $data = OrderDataFactory::validForCustomer();
        $command = new CreateOrderCommand($data);

        $orderMock = $this->createMock(Order::class);
        $orderMock
            ->method('getId')
            ->willReturn($orderId);

        $this->orderHydrator
            ->expects($this->once())
            ->method('hydrate')
            ->with(
                $this->identicalTo($data),
                $this->isInstanceOf(Order::class)
            )
            ->willReturn($orderMock);

        $this->orderRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->identicalTo($orderMock));

        $handler = new CreateOrderCommandHandler(
            hydrator:           $this->orderHydrator,
            repository:          $this->orderRepository,
            customerRepository:  $this->customerRepository,
            customerHydrator:    $this->customerHydrator,
            customerDataMapper:  $this->customerDataMapper,
        );

        $response = $handler->__invoke($command);
        $this->assertSame($orderId, $response->getId());
    }
}
