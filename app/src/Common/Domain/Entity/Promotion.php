<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Enums\DecimalPrecision;
use App\Common\Domain\Enums\PromotionSource;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\Traits\ActiveTrait;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use App\Common\Infrastructure\Repository\PromotionDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Promotion
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'promotions')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Product $product = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $startsAt;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $endsAt;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value
    )]
    private string $reduction;

    #[ORM\Column(type: 'string', enumType: ReductionType::class)]
    private ReductionType $type;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true, 'default' => 1])]
    private int $fromQuantity = 1;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true])]
    private ?int $usageLimit = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true])]
    private ?int $usagePerUser = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $couponCode = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true])]
    private int $priority = 1;

    #[ORM\Column(type: 'string', enumType: PromotionSource::class)]
    private ?PromotionSource $source;

    public function getId(): int
    {
        return $this->id;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function setReduction(string $reduction): void
    {
        $this->reduction = $reduction;
    }

    public function setType(ReductionType $type): void
    {
        $this->type = $type;
    }

    public function setFromQuantity(int $fromQuantity): void
    {
        $this->fromQuantity = $fromQuantity;
    }

    public function setUsageLimit(?int $usageLimit): void
    {
        $this->usageLimit = $usageLimit;
    }

    public function setUsagePerUser(?int $usagePerUser): void
    {
        $this->usagePerUser = $usagePerUser;
    }

    public function setCouponCode(?string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    public function getStartsAt(): \DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): \DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getReduction(): string
    {
        return $this->reduction;
    }

    public function getType(): ReductionType
    {
        return $this->type;
    }

    public function getFromQuantity(): int
    {
        return $this->fromQuantity;
    }

    public function getUsageLimit(): ?int
    {
        return $this->usageLimit;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function getUsagePerUser(): ?int
    {
        return $this->usagePerUser;
    }

    public function getSource(): ?PromotionSource
    {
        return $this->source;
    }

    public function setSource(?PromotionSource $source): void
    {
        $this->source = $source;
    }

    public function isActiveNow(): bool
    {
        return $this->isActive() && $this->hasStarted() && !$this->hasExpired();
    }

    public function hasStarted(): bool
    {
        return $this->startsAt < new \DateTimeImmutable();
    }

    public function hasExpired(): bool
    {
        return $this->endsAt < new \DateTimeImmutable();
    }
}
