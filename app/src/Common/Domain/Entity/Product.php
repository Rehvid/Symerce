<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Application\Contracts\IdentifiableInterface;
use App\Common\Domain\Contracts\PositionEntityInterface;
use App\Common\Domain\Enums\DecimalPrecision;
use App\Common\Domain\Enums\PromotionSource;
use App\Common\Domain\Traits\ActiveTrait;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\PositionTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use App\Product\Infrastructure\Repository\ProductDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product implements PositionEntityInterface, IdentifiableInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use ActiveTrait;
    use PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $slug;

    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value
    )]
    private string $regularPrice;


    #[ORM\ManyToOne(targetEntity: Brand::class)]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Brand $brand;

    /** @var Collection<int, Category> */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'product_categories')]
    private Collection $categories;

    /** @var Collection<int, Tag>  $tags */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'product_tag')]
    private Collection $tags;

    /** @var Collection<int, ProductImage> */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $images;

    /** @var Collection<int, ProductAttribute> */
    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $attributes;

    /** @var Collection<int, Promotion> */
    #[ORM\OneToMany(targetEntity: Promotion::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['priority' => 'ASC'])]
    private Collection $promotions;

    /** @var Collection<int, ProductPriceHistory> */
    #[ORM\OneToMany(targetEntity: ProductPriceHistory::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $priceHistory;

    /** @var Collection<int, ProductStock> */
    #[ORM\OneToMany(targetEntity: ProductStock::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productStocks;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'main_category_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Category $mainCategory = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $metaDescription = null;

    /** @var Collection<int, OrderItem> $orderItems */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'product')]
    private Collection $orderItems;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->priceHistory = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->productStocks = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
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
        return $this->hasActivePromotion() ? $this->promotions->first()->getDiscountPrice() : null;
    }

    /** @return Collection<int, Tag> */
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

    /** @return Collection<int, ProductImage> */
    public function getImages(): Collection
    {
        return $this->images;
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
        $thumbnail = $this->images
            ->filter(fn (ProductImage $image) => $image->isThumbnail())
            ->first();

        return $thumbnail instanceof ProductImage ? $thumbnail : null;
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

    /** @return Collection<int, Promotion> */
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

    /** @return Collection<int, ProductPriceHistory> */
    public function getPriceHistory(): Collection
    {
        return $this->priceHistory;
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
            fn (Promotion $promotion) => PromotionSource::PRODUCT_TAB === $promotion->getSource()
        )->first();

        if (!$promotion) {
            return null;
        }

        return $promotion;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    public function addStock(ProductStock $stock): void
    {
        if (!$this->productStocks->contains($stock)) {
            $this->productStocks->add($stock);
        }
    }

    /** @return Collection<int, ProductStock> */
    public function getProductStocks(): Collection
    {
        return $this->productStocks;
    }

    /** @return Collection<int, ProductAttribute> */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addProductAttribute(ProductAttribute $attribute): void
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
        }
    }

    public function isInStock(): bool
    {
        $totalQuantity = 0;
        foreach ($this->productStocks as $productStock) {
            $totalQuantity += $productStock->getAvailableQuantity();
        }

        return $totalQuantity > 0;
    }

    public function hasActivePromotion(): bool
    {
        foreach ($this->promotions as $promotion) {
            if ($promotion->isActiveNow()) {
                return true;
            }
        }

        return false;
    }

    public function getActiveNowPromotions(): Collection
    {
        return $this->promotions->filter(fn (Promotion $promotion) => $promotion->isActiveNow());
    }
}
