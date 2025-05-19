<?php

declare(strict_types=1);

namespace App\Entity;

use App\Admin\Infrastructure\Repository\AttributeValueDoctrineRepository;
use App\Interfaces\IdentifiableEntityInterface;
use App\Interfaces\OrderSortableInterface;
use App\Traits\OrderTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeValueDoctrineRepository::class)]
class AttributeValue implements OrderSortableInterface, IdentifiableEntityInterface
{
    use OrderTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $value;

    #[ORM\ManyToOne(targetEntity: Attribute::class, inversedBy: 'values')]
    #[ORM\JoinColumn(name: 'attribute_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private Attribute $attribute;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(Attribute $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
