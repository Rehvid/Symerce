<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Admin\Domain\Contract\HasFileInterface;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\CreatedAtTrait;
use App\Admin\Domain\Traits\UpdatedAtTrait;
use App\Carrier\Infrastructure\Repository\CarrierDoctrineRepository;
use App\Shared\Domain\Enums\DecimalPrecision;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Carrier implements HasFileInterface
{
    use CreatedAtTrait, UpdatedAtTrait, ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value,
        nullable: true
    )]
    private ?string $fee = null;

    #[ORM\ManyToOne(targetEntity: File::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'thumbnail_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?File $thumbnail = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $externalData = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isExternal = false;


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


    public function setFile(File $file): void
    {
        $this->thumbnail = $file;
    }

    public function getFile(): ?File
    {
        return $this->thumbnail;
    }

    public function getExternalData(): ?array
    {
        return $this->externalData;
    }

    public function setExternalData(?array $externalData): void
    {
        $this->externalData = $externalData;
    }

    public function isExternal(): bool
    {
        return $this->isExternal;
    }

    public function setIsExternal(bool $isExternal): void
    {
        $this->isExternal = $isExternal;
    }
}
