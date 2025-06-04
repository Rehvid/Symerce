<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Enums\DecimalPrecision;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use App\Order\Domain\Enums\CheckoutStep;
use App\Order\Domain\Enums\OrderStatus;
use App\Order\Infrastructure\Repository\OrderDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: OrderDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'orders')]
class Order
{
    use CreatedAtTrait, UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'guid', unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cartToken;

    #[ORM\OneToOne(targetEntity: DeliveryAddress::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'delivery_address_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?DeliveryAddress $deliveryAddress = null;

    #[ORM\OneToOne(targetEntity: InvoiceAddress::class, cascade: ['persist', 'remove'], orphanRemoval: true,)]
    #[ORM\JoinColumn(name: 'invoice_address_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
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

    #[ORM\OneToOne(targetEntity: ContactDetails::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'contact_details_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ContactDetails $contactDetails;

    #[ORM\Column(type: 'string', enumType: CheckoutStep::class)]
    private CheckoutStep $checkoutStep;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

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

    public function getCartToken(): ?string
    {
        return $this->cartToken;
    }

    public function setCartToken(?string $cartToken): void
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


}
