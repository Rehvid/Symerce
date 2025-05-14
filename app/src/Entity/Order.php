<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\DecimalPrecision;
use App\Enums\OrderStatus;
use App\Repository\OrderRepository;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Order
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'guid', unique: true)]
    private UuidInterface $uuid;

    #[ORM\ManyToOne(targetEntity: DeliveryAddress::class)]
    #[ORM\JoinColumn(name: "delivery_address_id", referencedColumnName: "id", nullable: true)]
    private ?DeliveryAddress $deliveryAddress = null;

    #[ORM\ManyToOne(targetEntity: InvoiceAddress::class)]
    #[ORM\JoinColumn(name: "invoice_address_id", referencedColumnName: "id", nullable: true)]
    private ?InvoiceAddress $invoiceAddress = null;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "id", nullable: true)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(targetEntity: Carrier::class)]
    #[ORM\JoinColumn(name: "carrier_id", referencedColumnName: "id", nullable: true)]
    private ?Carrier $carrier = null;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value,
        nullable: true
    )]
    private ?string $totalPrice = null;

    #[ORM\Column(type: 'string', enumType: OrderStatus::class)]
    private OrderStatus $status = OrderStatus::NEW;

    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'order')]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    private Collection $orderItems;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->payments = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDeliveryAddress(): ?DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?DeliveryAddress $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getInvoiceAddress(): ?InvoiceAddress
    {
        return $this->invoiceAddress;
    }

    public function setInvoiceAddress(?InvoiceAddress $invoiceAddress): void
    {
        $this->invoiceAddress = $invoiceAddress;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): void
    {
        $this->carrier = $carrier;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?string $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): void
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
        }
    }

    public function removePayment(Payment $payment): void
    {
        if ($this->payments->contains($payment)) {
            $this->payments->removeElement($payment);
        }
    }

    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): void
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
        }
    }

    public function removeOrderItem(OrderItem $orderItem): void
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
        }
    }
}
