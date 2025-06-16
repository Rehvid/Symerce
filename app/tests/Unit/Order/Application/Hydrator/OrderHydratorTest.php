<?php

declare(strict_types=1);

namespace App\Tests\Unit\Order\Application\Hydrator;

use App\Common\Application\Factory\OrderItemFactory;
use App\Common\Application\Hydrator\AddressHydrator;
use App\Common\Application\Hydrator\ContactDetailsHydrator;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\ContactDetails;
use App\Common\Domain\Entity\DeliveryAddress;
use App\Common\Domain\Entity\InvoiceAddress;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\Service\ProductPriceCalculator;
use App\Common\Domain\ValueObject\MoneyVO;
use App\Order\Application\Dto\OrderData;
use App\Order\Application\Dto\OrderPriceSummary;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Application\Service\OrderPriceCalculator;
use App\Tests\Helper\CurrencyFactory;
use App\Tests\Unit\Order\Application\Helper\OrderDataFactory;
use PHPUnit\Framework\TestCase;

final class OrderHydratorTest extends TestCase
{
    private ContactDetailsHydrator $contactDetailsHydrator;
    private AddressHydrator        $addressHydrator;
    private ProductPriceCalculator $productPriceCalculator;
    private OrderItemFactory     $orderItemFactory;
    private OrderPriceCalculator  $orderPriceCalculator;

    private OrderHydrator $hydrator;

    protected function setUp(): void
    {
        $this->contactDetailsHydrator = $this->createMock(ContactDetailsHydrator::class);
        $this->addressHydrator        = $this->createMock(AddressHydrator::class);
        $this->productPriceCalculator = $this->createMock(ProductPriceCalculator::class);
        $this->orderItemFactory       = $this->createMock(OrderItemFactory::class);
        $this->orderPriceCalculator   = $this->createMock(OrderPriceCalculator::class);

        $this->hydrator = new OrderHydrator(
            contactDetailsHydrator: $this->contactDetailsHydrator,
            addressHydrator:        $this->addressHydrator,
            productPriceCalculator: $this->productPriceCalculator,
            orderItemFactory:       $this->orderItemFactory,
            orderPriceCalculator:   $this->orderPriceCalculator,
        );
    }

    public function testHydrateGuestPopulatesAllFields(): void
    {
        $totalPrice = '999.99';

        $data = OrderDataFactory::validForGuest();
        $order = new Order();

        $this->contactDetailsHydrator
            ->expects($this->once())
            ->method('hydrate')
            ->with(
                $this->identicalTo($data->contactDetailsData),
                $this->isInstanceOf(ContactDetails::class)
            )
            ->willReturnCallback(fn($dto, ContactDetails $contactDetails) => $contactDetails);

        $this->addressHydrator
            ->expects($this->exactly(2))
            ->method('hydrate')
            ->willReturnCallback(function($dto, Address $addr) use (&$addressCalls) {
                $addressCalls[] = $dto;
                return $addr;
            });

        $createdItems   = [];
        $orderItemCalls = [];
        $this->orderItemFactory
            ->expects($this->exactly(count($data->orderItems)))
            ->method('create')
            ->willReturnCallback(function(int $quantity, $product, Order $o) use (&$orderItemCalls, &$createdItems) {
                $orderItemCalls[] = ['quantity' => $quantity, 'product' => $product];
                $item = new OrderItem();
                $createdItems[] = $item;
                return $item;
            });

        $priceSummary = new OrderPriceSummary(
            totalProductPrice: null,
            total: new MoneyVO($totalPrice, CurrencyFactory::valid()),
            carrierFee: null,
            paymentMethodFee: null
        );
        $this->orderPriceCalculator
            ->expects($this->once())
            ->method('calculatePriceSummary')
            ->with($this->isInstanceOf(Order::class))
            ->willReturn($priceSummary);

        $result = $this->hydrator->hydrate($data, $order);

        $this->assertSame($order, $result);

        $this->assertSame($data->email,            $order->getEmail());
        $this->assertSame($data->carrier,          $order->getCarrier());
        $this->assertSame($data->paymentMethod,    $order->getPaymentMethod());
        $this->assertSame($data->checkoutStep,     $order->getCheckoutStep());
        $this->assertSame($data->orderStatus,      $order->getStatus());
        $this->assertNull($order->getCustomer());

        $this->assertInstanceOf(ContactDetails::class, $order->getContactDetails());
        $this->assertInstanceOf(DeliveryAddress::class, $order->getDeliveryAddress());
        $this->assertSame(
            $data->deliveryInstructions,
            $order->getDeliveryAddress()->getDeliveryInstructions()
        );

        $this->assertInstanceOf(InvoiceAddress::class, $order->getInvoiceAddress());
        $this->assertSame(
            $data->invoiceCompanyName,
            $order->getInvoiceAddress()->getCompanyName()
        );
        $this->assertSame(
            $data->invoiceCompanyTaxId,
            $order->getInvoiceAddress()->getCompanyTaxId()
        );

        $items = $order->getOrderItems()->toArray();
        $this->assertCount(count($data->orderItems), $items);
        $this->assertEquals($createdItems, $items);

        $this->assertSame($totalPrice, $order->getTotalPrice());
    }

    public function testHydrateCustomerPopulatesAllFields(): void
    {
        $totalPrice = '123.45';

        $data = OrderDataFactory::validForCustomer();
        $order = new Order();

        $order->setCustomer($data->customer);

        $this->contactDetailsHydrator
            ->expects($this->never())
            ->method('hydrate');

        $this->addressHydrator
            ->expects($this->never())
            ->method('hydrate');

        $createdItems = [];
        $orderItemCalls = [];
        $this->orderItemFactory
            ->expects($this->exactly(count($data->orderItems)))
            ->method('create')
            ->willReturnCallback(function(int $quantity, $product, Order $order) use (&$orderItemCalls, &$createdItems) {
                $orderItemCalls[] = ['quantity' => $quantity, 'product' => $product];
                $item = new OrderItem();
                $createdItems[] = $item;
                return $item;
            });


        $priceSummary = new OrderPriceSummary(
            totalProductPrice: null,
            total: new MoneyVO($totalPrice, CurrencyFactory::valid()),
            carrierFee: null,
            paymentMethodFee: null
        );

        $this->orderPriceCalculator
            ->expects($this->once())
            ->method('calculatePriceSummary')
            ->with($this->isInstanceOf(Order::class))
            ->willReturn($priceSummary);

        $result = $this->hydrator->hydrate($data, $order);

        $this->assertSame($order, $result);
        $this->assertSame($data->email,         $order->getEmail());
        $this->assertSame($data->carrier,       $order->getCarrier());
        $this->assertSame($data->paymentMethod, $order->getPaymentMethod());
        $this->assertSame($data->checkoutStep,  $order->getCheckoutStep());
        $this->assertSame($data->orderStatus,   $order->getStatus());
        $this->assertSame($data->customer, $order->getCustomer());

        $this->assertNull($order->getContactDetails());
        $this->assertNull($order->getDeliveryAddress());
        $this->assertNull($order->getInvoiceAddress());

        $items = $order->getOrderItems()->toArray();
        $this->assertEquals($createdItems, $items);

        $this->assertSame($totalPrice, $order->getTotalPrice());
    }
}
