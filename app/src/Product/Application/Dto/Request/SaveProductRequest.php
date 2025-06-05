<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Admin\Domain\Model\ProductFileData;
use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Domain\ValueObject\DateVO;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;


final class SaveProductRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $regularPrice;


    #[Assert\NotBlank]
    public int $mainCategory;

    #[Assert\NotBlank]
    public bool $isActive;

    public array $categories;

    public array $tags;

    public array $stocks;

    public array $images;

    public array $attributes;

    public string|int|null $brand;

    public ?string $slug;

    public ?string $description;
    public ?SaveProductPromotionRequest $productPromotionRequest;

    public ?string $metaTitle;

    public ?string $metaDescription;

    /**
     * @param array<int, mixed>         $categories
     * @param array<int, mixed>         $tags
     * @param SaveProductImageRequest[]         $images
     * @param array<string, mixed>      $attributes
     */
    public function __construct(
        string $name,
        string $regularPrice,
        array $stocks,
        int $mainCategory,
        bool $isActive,
        array $categories = [],
        array $tags = [],
        array $images = [],
        array $attributes = [],
        string|int|null $brand = null,
        ?string $slug = null,
        ?string $description = null,
        ?SaveProductPromotionRequest $productPromotionRequest = null,
        ?string $metaTitle = null,
        ?string $metaDescription = null,
    ) {
        $this->name = $name;
        $this->regularPrice = $regularPrice;
        $this->stocks = $stocks;
        $this->mainCategory = $mainCategory;
        $this->isActive = $isActive;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->images = $images;
        $this->attributes = $attributes;
        $this->brand = $brand;
        $this->slug = $slug;
        $this->description = $description;
        $this->productPromotionRequest = $productPromotionRequest;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $promotionIsActive = $data['promotionIsActive'] ?? false;
        $productPromotionRequest = null;
        if ($promotionIsActive) {
            $promotionDateRange = $data['promotionDateRange'] ?? null;
            $productPromotionRequest = new SaveProductPromotionRequest(
                isActive: $promotionIsActive,
                reductionType: $data['promotionReductionType'],
                reduction: $data['promotionReduction'],
                startDate: new DateVO($promotionDateRange ? $promotionDateRange[0] : ''),
                endDate: new DateVO($promotionDateRange ? $promotionDateRange[1] : ''),
                source: $data['promotionSource'] ?? null,
            );
        }

        $images = $data['images'] ?? [];
        if (!empty($images)) {
            $saveProductImageCollection = [];
            foreach ($images as $image) {
                $id = $image['id'] ?? null;
                if (null === $id) {
                    $saveProductImageCollection[] = new SaveProductImageRequest(
                        isThumbnail: $image['isThumbnail'] ?? false,
                        uploadData: FileData::fromArray($image),
                    );
                } else {
                    $saveProductImageCollection[] = new SaveProductImageRequest(
                        fileId: $id,
                        isThumbnail: $image['isThumbnail'] ?? false,
                    );
                }
            }
            $images = $saveProductImageCollection;
        }

        return new self(
            name: $data['name'],
            regularPrice: $data['regularPrice'],
            stocks: $data['stocks'],
            mainCategory: $data['mainCategory'],
            isActive: $data['isActive'],
            categories: $data['categories'],
            tags: $data['tags'],
            images: $images,
            attributes: $data['attributes'],
            brand: $data['brand'],
            slug: $data['slug'],
            description: $data['description'],
            productPromotionRequest: $productPromotionRequest,
            metaTitle: $data['metaTitle'] ?? null,
            metaDescription: $data['metaDescription'] ?? null,
        );
    }
}
