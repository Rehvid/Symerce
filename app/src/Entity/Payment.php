<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\DecimalPrecision;
use App\Enums\PaymentStatus;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Payment
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'payments')]
    private Order $order;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value,
        nullable: true
    )]
    private ?string $amount = null;

    #[ORM\Column(type: 'string', enumType: PaymentStatus::class)]
    private PaymentStatus $status = PaymentStatus::UNPAID;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $paidAt;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $gatewayTransactionId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }

    public function setStatus(PaymentStatus $status): void
    {
        $this->status = $status;
    }

    public function getPaidAt(): \DateTime
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTime $paidAt): void
    {
        $this->paidAt = $paidAt;
    }
}
