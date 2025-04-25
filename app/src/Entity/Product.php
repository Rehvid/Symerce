<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\DecimalPrecision;
use App\Repository\ProductRepository;
use App\Traits\ActiveTrait;
use App\Traits\CreatedAtTrait;
use App\Traits\OrderTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
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


    #[ORM\Column(
        type: 'decimal',
        precision: DecimalPrecision::MAXIMUM_PRECISION->value,
        scale: DecimalPrecision::MAXIMUM_SCALE->value
    )]
    private string $discountPrice;

    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => true, 'default' => 0])]
    private int $quantity = 0;

    #[ORM\ManyToOne(targetEntity: Vendor::class)]
    #[ORM\JoinColumn(name: 'vendor_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Vendor $vendor;

    /** @var Collection<int, Category> */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'product_category')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'product_tag')]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: DeliveryTime::class)]
    #[ORM\JoinTable(name: 'product_delivery_time')]
    private Collection $deliveryTimes;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: AttributeValue::class)]
    #[ORM\JoinTable(name: 'product_attribute_value')]
    private Collection $attributeValues;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->deliveryTimes = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
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

    public function getDiscountPrice(): string
    {
        return $this->discountPrice;
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

    public function getDeliveryTimes(): Collection
    {
        return $this->deliveryTimes;
    }

    public function addAttributeValue(AttributeValue $attributeValue): void
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->add($attributeValue);
        }
    }

    public function removeAttributeValue(AttributeValue $attributeValue): void
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

    public function addDeliveryTime(DeliveryTime $deliveryTime): void
    {
        if (!$this->deliveryTimes->contains($deliveryTime)) {
            $this->deliveryTimes->add($deliveryTime);
        }
    }

    public function removeDeliveryTime(DeliveryTime $deliveryTime): void
    {
        if ($this->deliveryTimes->contains($deliveryTime)) {
            $this->deliveryTimes->removeElement($deliveryTime);
        }
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

    public function setDiscountPrice(string $discountPrice): void
    {
        $this->discountPrice = $discountPrice;
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
}
