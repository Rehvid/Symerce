<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use App\Admin\Domain\Contract\OrderEntityInterface;
use App\Admin\Domain\Enums\PromotionSource;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\CreatedAtTrait;
use App\Admin\Domain\Traits\OrderTrait;
use App\Admin\Domain\Traits\UpdatedAtTrait;
use App\Admin\Infrastructure\Repository\ProductDoctrineRepository;
use App\Shared\Domain\Enums\DecimalPrecision;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product implements OrderEntityInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use ActiveTrait;
    use OrderTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $slug;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value
    )]
    private string $regularPrice;


    private ?string $discountPrice = null;

    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => true, 'default' => 0])]
    private int $quantity = 0;

    #[ORM\ManyToOne(targetEntity: Vendor::class)]
    #[ORM\JoinColumn(name: 'vendor_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Vendor $vendor;

    /** @var Collection<int, Category> */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'product_categories')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'product_tag')]
    private Collection $tags;

    #[ORM\ManyToOne(targetEntity: DeliveryTime::class)]
    #[ORM\JoinColumn(name: 'delivery_time_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private DeliveryTime $deliveryTime;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['order' => 'ASC'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: AttributeValue::class)]
    #[ORM\JoinTable(name: 'product_attribute_value')]
    private Collection $attributeValues;

    #[ORM\OneToMany(targetEntity: Promotion::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $promotions;

    #[ORM\OneToMany(targetEntity: ProductPriceHistory::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $priceHistory;

    #[ORM\OneToOne(targetEntity: ProductStock::class, mappedBy: "product", cascade: ["persist", "remove"])]
    private ?ProductStock $stock = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'main_category_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Category $mainCategory = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->priceHistory = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /** @return Collection<int, Category>   */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
    }

    public function removeCategory(Category $category): void
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getRegularPrice(): string
    {
        return $this->regularPrice;
    }

    public function getDiscountPrice(): ?string
    {
        return $this->regularPrice;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function addAttributeValue(AttributeValue $attributeValue): void
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->add($attributeValue);
        }
    }

    public function removeAttribute(AttributeValue $attributeValue): void
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
        }
    }

    public function addImage(ProductImage $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }
    }

    public function removeImage(ProductImage $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

    public function getThumbnailImage(): ?ProductImage
    {
        $thumbnailImage = null;
        $findThumbnail = $this->images->filter(fn (ProductImage $image) => $image->isThumbnail());
        if ($findThumbnail->count() > 0) {
            $thumbnailImage = $findThumbnail->first();
        }

        return $thumbnailImage;
    }

    public function setVendor(?Vendor $vendor): void
    {
        $this->vendor = $vendor;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setRegularPrice(string $regularPrice): void
    {
        $this->regularPrice = $regularPrice;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getDeliveryTime(): DeliveryTime
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(DeliveryTime $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function getCurrentPrice(): string
    {
        return $this->regularPrice;
    }

    public function addPromotion(Promotion $promotion): void
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
        }
    }

    public function removePromotion(Promotion $promotion): void
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
        }
    }

    public function getPromotions(): Collection
    {
        return $this->promotions;
    }
    public function addPriceHistory(ProductPriceHistory $priceHistory): void
    {
        if (!$this->priceHistory->contains($priceHistory)) {
            $this->priceHistory->add($priceHistory);
        }
    }

    public function removePriceHistory(ProductPriceHistory $priceHistory): void
    {
        if ($this->priceHistory->contains($priceHistory)) {
            $this->priceHistory->removeElement($priceHistory);
        }
    }

    public function getProductPriceHistory(): Collection
    {
        return $this->priceHistory;
    }

    public function getPriceHistory(): Collection
    {
        return $this->priceHistory;
    }

    public function setPriceHistory(Collection $priceHistory): void
    {
        $this->priceHistory = $priceHistory;
    }

    public function hasStock(): bool
    {
        return $this->stock !== null;
    }

    public function getStock(): ProductStock
    {
        if (!$this->hasStock()) {
            throw new \LogicException('Product stock is not initialized.');
        }

        return $this->stock;
    }

    public function setStock(ProductStock $stock): void
    {
        $this->stock = $stock;
    }

    public function getMainCategory(): ?Category
    {
        return $this->mainCategory;
    }

    public function setMainCategory(?Category $mainCategory): void
    {
        $this->mainCategory = $mainCategory;
    }

    public function getPromotionForProductTab(): ?Promotion
    {
        $promotion = $this->promotions->filter(
            fn(Promotion $promotion) => $promotion->getSource() === PromotionSource::PRODUCT_TAB
        )->first();

        if (!$promotion) {
            return null;
        }

        return $promotion;
    }
}
