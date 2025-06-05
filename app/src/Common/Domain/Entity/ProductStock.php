<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productStocks')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Product $product;

    #[ORM\Column(type: 'integer')]
    private int $availableQuantity;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $lowStockThreshold;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $maximumStockLevel;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $ean13 = null;

    #[ORM\ManyToOne(targetEntity: Warehouse::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?Warehouse $warehouse = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $restockDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getAvailableQuantity(): int
    {
        return $this->availableQuantity;
    }

    public function setAvailableQuantity(int $availableQuantity): void
    {
        $this->availableQuantity = $availableQuantity;
    }

    public function getLowStockThreshold(): ?int
    {
        return $this->lowStockThreshold;
    }

    public function setLowStockThreshold(?int $lowStockThreshold): void
    {
        $this->lowStockThreshold = $lowStockThreshold;
    }

    public function getMaximumStockLevel(): ?int
    {
        return $this->maximumStockLevel;
    }

    public function setMaximumStockLevel(?int $maximumStockLevel): void
    {
        $this->maximumStockLevel = $maximumStockLevel;
    }

    public function isLowStock(): bool
    {
        if (null === $this->lowStockThreshold) {
            return false;
        }

        return $this->availableQuantity <= $this->lowStockThreshold;
    }

    public function hasReachedMaxStock(): bool
    {
        if (null === $this->maximumStockLevel) {
            return false;
        }

        return $this->availableQuantity >= $this->maximumStockLevel;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    public function getEan13(): ?string
    {
        return $this->ean13;
    }

    public function setEan13(?string $ean13): void
    {
        $this->ean13 = $ean13;
    }

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    public function getRestockDate(): ?\DateTimeInterface
    {
        return $this->restockDate;
    }

    public function setRestockDate(?\DateTimeInterface $restockDate): void
    {
        $this->restockDate = $restockDate;
    }
}
