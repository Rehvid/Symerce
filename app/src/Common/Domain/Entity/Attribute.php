<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Attribute\Domain\Enums\AttributeType;
use App\Attribute\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Common\Domain\Contracts\PositionEntityInterface;
use App\Common\Domain\Traits\ActiveTrait;
use App\Common\Domain\Traits\PositionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeDoctrineRepository::class)]
class Attribute implements PositionEntityInterface
{
    use PositionTrait, ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', enumType: AttributeType::class)]
    private AttributeType $type;

    #[ORM\OneToMany(targetEntity: AttributeValue::class, mappedBy: 'attribute', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
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

    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValues(AttributeValue $value): void
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
        }
    }

    public function removeValues(AttributeValue $value): void
    {
        if ($this->values->contains($value)) {
            $this->values->removeElement($value);
        }
    }

    public function getType(): AttributeType
    {
        return $this->type;
    }

    public function setType(AttributeType $type): void
    {
        $this->type = $type;
    }
}
