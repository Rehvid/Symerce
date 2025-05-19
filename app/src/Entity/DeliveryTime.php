<?php

declare(strict_types=1);

namespace App\Entity;

use App\Admin\Domain\Enums\DeliveryType;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\OrderTrait;
use App\Admin\Infrastructure\Repository\DeliveryTimeDoctrineRepository;
use App\Interfaces\IdentifiableEntityInterface;
use App\Interfaces\OrderSortableInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryTimeDoctrineRepository::class)]
class DeliveryTime implements OrderSortableInterface, IdentifiableEntityInterface
{
    use ActiveTrait;
    use OrderTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $label;

    #[ORM\Column(type: 'integer')]
    private int $minDays;

    #[ORM\Column(type: 'integer')]
    private int $maxDays;

    #[ORM\Column(type: 'string', enumType: DeliveryType::class)]
    private DeliveryType $type;

    #[ORM\ManyToMany(targetEntity: Carrier::class, inversedBy: 'deliveryTimes', cascade: ['persist', 'remove'])]
    #[ORM\JoinTable(name: 'carrier_delivery_times')]
    private Collection $carriers;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getMinDays(): int
    {
        return $this->minDays;
    }

    public function setMinDays(int $minDays): void
    {
        $this->minDays = $minDays;
    }

    public function getMaxDays(): int
    {
        return $this->maxDays;
    }

    public function setMaxDays(int $maxDays): void
    {
        $this->maxDays = $maxDays;
    }

    public function getType(): DeliveryType
    {
        return $this->type;
    }

    public function setType(DeliveryType $type): void
    {
        $this->type = $type;
    }

    public function getCarriers(): Collection
    {
        return $this->carriers;
    }
}
