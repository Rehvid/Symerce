<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Contracts\PositionEntityInterface;
use App\Common\Domain\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductImage implements PositionEntityInterface
{
    use PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: File::class, cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private File $file;

    #[ORM\Column(type: 'boolean')]
    private bool $isThumbnail = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(File $file): void
    {
        $this->file = $file;
    }

    public function isThumbnail(): bool
    {
        return $this->isThumbnail;
    }

    public function setIsThumbnail(bool $isThumbnail): void
    {
        $this->isThumbnail = $isThumbnail;
    }
}
