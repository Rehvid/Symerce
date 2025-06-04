<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Admin\Domain\Model\ProductFileData;
use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\RequestDtoInterface;
use App\Common\Domain\ValueObject\DateVO;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;


final class SaveProductRequest implements RequestDtoInterface, ArrayHydratableInterface
{
    /**
     * @param array<int, mixed>         $categories
     * @param array<int, mixed>         $tags
     * @param SaveProductImageRequest[]         $images
     * @param array<string, mixed>      $attributes
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision]  public string $regularPrice,
        public array $stocks,
        public int $mainCategory,
        public bool $isActive,
        public array $categories = [],
        public array $tags = [],
        public array $images = [],
        public array $attributes = [],
        public string|int|null $brand = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?SaveProductPromotionRequest $productPromotionRequest = null,
        public ?string $metaTitle = null,
        public ?string $metaDescription = null,
    ) {
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
