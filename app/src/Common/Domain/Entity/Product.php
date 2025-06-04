<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Admin\Domain\Contract\PositionEntityInterface;
use App\Admin\Domain\Enums\PromotionSource;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\CreatedAtTrait;
use App\Admin\Domain\Traits\PositionTrait;
use App\Admin\Domain\Traits\UpdatedAtTrait;
use App\Product\Infrastructure\Repository\ProductDoctrineRepository;
use App\Shared\Domain\Enums\DecimalPrecision;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product implements PositionEntityInterface
{
    use CreatedAtTrait, UpdatedAtTrait, ActiveTrait, PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

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


    #[ORM\ManyToOne(targetEntity: Brand::class)]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Brand $brand;

    /** @var Collection<int, Category> */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'product_categories')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'product_tag')]
    private Collection $tags;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $images;

    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $attributes;

    #[ORM\OneToMany(targetEntity: Promotion::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $promotions;

    #[ORM\OneToMany(targetEntity: ProductPriceHistory::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $priceHistory;

    #[ORM\OneToMany(targetEntity: ProductStock::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productStocks;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'main_category_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Category $mainCategory = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $metaDescription = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->priceHistory = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->productStocks = new ArrayCollection();
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
        return $this->regularPrice;
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
            fn(Promotion $promotion) => $promotion->getSource() === PromotionSource::PRODUCT_TAB
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

    public function getProductStocks(): Collection
    {
        return $this->productStocks;
    }

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
}
