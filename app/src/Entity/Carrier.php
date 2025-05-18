<?php

declare(strict_types=1);

namespace App\Entity;

use App\Admin\Domain\Contract\HasFileInterface;
use App\Admin\Infrastructure\Repository\CarrierDoctrineRepository;
use App\Enums\DecimalPrecision;
use App\Interfaces\IdentifiableEntityInterface;
use App\Traits\ActiveTrait;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Carrier implements IdentifiableEntityInterface, HasFileInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

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
    private ?File $image = null;

    #[ORM\ManyToMany(targetEntity: DeliveryTime::class, mappedBy: 'carriers')]
    private Collection $deliveryTimes;

    public function __construct()
    {
        $this->deliveryTimes = new ArrayCollection();
    }

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
        return $this->getFile();
    }

    public function setImage(?File $image): void
    {
        $this->image = $image;
    }

    public function getDeliveryTimes(): Collection
    {
        return $this->deliveryTimes;
    }

    public function setFile(File $file): void
    {
        $this->image = $file;
    }

    public function getFile(): ?File
    {
        return $this->image;
    }
}
