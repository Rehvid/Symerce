<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Cart\Infrastructure\Repository\CartDoctrineRepository;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cart
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Customer $customer = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $token;


    /** @var Collection<int, CartItem> */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $expiresAt = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /** @return Collection<int, CartItem> */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CartItem $cartItem): void
    {
        if (!$this->items->contains($cartItem)) {
            $this->items->add($cartItem);
        }
    }

    public function removeItem(CartItem $cartItem): void
    {
        if ($this->items->contains($cartItem)) {
            $this->items->removeElement($cartItem);
        }
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getTotalQuantity(): int
    {
        $totalQuantity = 0;

        foreach ($this->items as $item) {
            $totalQuantity += $item->getQuantity();
        }

        return $totalQuantity;
    }

    public function getCartItemByProductId(int $productId): ?CartItem
    {
        $filtered = $this->items->filter(fn (CartItem $cartItem) => $cartItem->getProduct()->getId() === $productId);
        $firstItem = $filtered->first();

        return $firstItem instanceof CartItem ? $firstItem : null;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }
}
