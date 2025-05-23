<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Product;

use App\Admin\Domain\Model\ProductFileData;
use App\Admin\Domain\ValueObject\DateVO;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;


final class SaveProductRequest implements RequestDtoInterface, ArrayHydratableInterface
{
    /**
     * @param array<int, mixed>         $categories
     * @param array<int, mixed>         $tags
     * @param array<int, mixed>         $deliveryTimes
     * @param ProductFileData[]         $images
     * @param array<string, mixed>      $attributes
     * @param array<string, mixed>|null $thumbnail
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision]  public string $regularPrice,
        public SaveProductStockRequest $productStockRequest,
        public int $mainCategory,
        public bool $isActive,
        public array $categories = [],
        public array $tags = [],
        public array $images = [],
        public array $attributes = [],
        public ?string $deliveryTime = null,
        public ?string $vendor = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?array $thumbnail = null,
        public ?SaveProductPromotionRequest $productPromotionRequest = null,
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
            $productFileImages = [];
            foreach ($images as $image) {
                $productFileImages[] = ProductFileData::fromArray($image);
            }
            $images = $productFileImages;
        }

        dd($images);
        return new self(
            name: $data['name'],
            regularPrice: $data['regularPrice'],
            productStockRequest: new SaveProductStockRequest(
                availableQuantity: $data['stockAvailableQuantity'],
                lowStockThreshold: $data['stockLowStockThreshold'] ?? null,
                maxStockLevel: $data['stockMaximumStockLevel'] ?? null,
                notifyOnLowStock: $data['stockNotifyOnLowStock'],
                visibleInStore: $data['stockVisibleInStore'],
                ean13: $data['ean13'] ?? null,
                sku: $data['sku'] ?? null,
            ),
            mainCategory: $data['mainCategory'],
            isActive: $data['isActive'],
            categories: $data['categories'],
            tags: $data['tags'],
            images: $images,
            attributes: $data['attributes'],
            deliveryTime: $data['deliveryTime'],
            vendor: $data['vendor'],
            slug: $data['slug'],
            description: $data['description'],
            thumbnail: $data['thumbnail'] ?? null,
            productPromotionRequest: $productPromotionRequest
        );
    }
}
