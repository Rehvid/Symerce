<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\OneToOne(targetEntity: Product::class, inversedBy: "stock")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Product $product;

    #[ORM\Column(type: 'integer')]
    private int $availableQuantity;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $lowStockThreshold;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $maximumStockLevel;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $notifyOnLowStock = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $visibleInStore = true;

    public function getId(): int
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

    public function isNotifyOnLowStock(): bool
    {
        return $this->notifyOnLowStock;
    }

    public function setNotifyOnLowStock(bool $notifyOnLowStock): void
    {
        $this->notifyOnLowStock = $notifyOnLowStock;
    }

    public function isVisibleInStore(): bool
    {
        return $this->visibleInStore;
    }

    public function setVisibleInStore(bool $visibleInStore): void
    {
        $this->visibleInStore = $visibleInStore;
    }

    public function isLowStock(): bool
    {
        if ($this->lowStockThreshold === null) {
            return false;
        }
        return $this->availableQuantity <= $this->lowStockThreshold;
    }

    public function hasReachedMaxStock(): bool
    {
        if ($this->maximumStockLevel === null) {
            return false;
        }

        return $this->availableQuantity >= $this->maximumStockLevel;
    }
}
