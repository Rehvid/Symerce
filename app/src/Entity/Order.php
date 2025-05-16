<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Embeddables\Address;
use App\Entity\Embeddables\ContactDetails;
use App\Enums\CheckoutStep;
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
#[ORM\Table(name: 'orders')]
class Order
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'guid', unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cartToken;

    #[ORM\ManyToOne(targetEntity: DeliveryAddress::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: "delivery_address_id", referencedColumnName: "id", nullable: true)]
    private ?DeliveryAddress $deliveryAddress = null;

    #[ORM\ManyToOne(targetEntity: InvoiceAddress::class, cascade: ['persist'])]
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

    #[ORM\ManyToOne(targetEntity: PaymentMethod::class)]
    #[ORM\JoinColumn(name: "payment_method_id", referencedColumnName: "id", nullable: true)]
    private ?PaymentMethod $paymentMethod = null;


    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $orderItems;

    #[ORM\Embedded(class: ContactDetails::class, columnPrefix: false)]
    private ContactDetails $contactDetails;

    #[ORM\Column(type: 'string', enumType: CheckoutStep::class)]
    private CheckoutStep $checkoutStep;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
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

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?string $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
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

    public function getCartToken(): string
    {
        return $this->cartToken;
    }

    public function setCartToken(string $cartToken): void
    {
        $this->cartToken = $cartToken;
    }


    public function getContactDetails(): ?ContactDetails
    {
        return $this->contactDetails;
    }

    public function setContactDetails(?ContactDetails $contactDetails): void
    {
        $this->contactDetails = $contactDetails;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getCheckoutStep(): CheckoutStep
    {
        return $this->checkoutStep;
    }

    public function setCheckoutStep(CheckoutStep $checkoutStep): void
    {
        $this->checkoutStep = $checkoutStep;
    }
}
