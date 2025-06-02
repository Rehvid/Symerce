<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Admin\Domain\Contract\PositionEntityInterface;
use App\Admin\Domain\Traits\PositionTrait;
use App\AttributeValue\Infrastructure\Repository\AttributeValueDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeValueDoctrineRepository::class)]
class AttributeValue implements PositionEntityInterface
{
    use PositionTrait;

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
