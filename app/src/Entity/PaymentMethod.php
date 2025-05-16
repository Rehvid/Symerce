<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\DecimalPrecision;
use App\Repository\PaymentMethodRepository;
use App\Traits\ActiveTrait;
use App\Traits\CreatedAtTrait;
use App\Traits\OrderTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PaymentMethod
{
    use ActiveTrait;
    use OrderTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $code;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value
    )]
    private string $fee;

    #[ORM\ManyToOne(targetEntity: File::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?File $image;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $config = null;


    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $requiresWebhook = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    public function setFee(string $fee): void
    {
        $this->fee = $fee;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): void
    {
        $this->image = $image;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getConfig(): ?array
    {
        return $this->config;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function setConfig(?array $config): void
    {
        $this->config = $config;
    }

    public function isRequiresWebhook(): bool
    {
        return $this->requiresWebhook;
    }

    public function setRequiresWebhook(bool $requiresWebhook): void
    {
        $this->requiresWebhook = $requiresWebhook;
    }
}
