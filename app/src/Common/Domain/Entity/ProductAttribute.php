<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'attributes')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Attribute::class)]
    private Attribute $attribute;

    #[ORM\ManyToOne(targetEntity: AttributeValue::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?AttributeValue $predefinedValue = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $customValue = null;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(Attribute $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getPredefinedValue(): ?AttributeValue
    {
        return $this->predefinedValue;
    }

    public function setPredefinedValue(?AttributeValue $predefinedValue): void
    {
        $this->predefinedValue = $predefinedValue;
    }

    public function getCustomValue(): ?string
    {
        return $this->customValue;
    }

    public function setCustomValue(?string $customValue): void
    {
        $this->customValue = $customValue;
    }
}
