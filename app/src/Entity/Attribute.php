<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\OrderSortableInterface;
use App\Repository\AttributeRepository;
use App\Traits\OrderTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
class Attribute implements OrderSortableInterface
{
    use OrderTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\OneToMany(targetEntity: AttributeValue::class, mappedBy: 'attribute', cascade: ['remove'])]
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
}
