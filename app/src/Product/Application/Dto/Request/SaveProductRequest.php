<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\ValueObject\DateVO;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueSlug;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;


final class SaveProductRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $regularPrice;

    #[Assert\Valid]
    public IdRequest $mainCategoryIdRequest;


    public bool $isActive;

    public array $categories;

    public array $tags;

    public array $stocks;

    public array $attributes;


    /**
     * @var SaveProductImageRequest[]
     */
    #[Assert\Valid]
    public array $images;

    #[Assert\Valid]
    public IdRequest $brandIdRequest;

    #[Assert\When(
        expression: 'this.slug !== null and this.slug != ""',
        constraints: [
            new CustomAssertUniqueSlug(options: ['field' => 'slug', 'className' => Product::class]),
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $slug;


    #[Assert\When(
        expression: 'this.description !== null and this.description != ""',
        constraints: [
            new Assert\Length(min: 3),
        ]
    )]
    public ?string $description;

    #[Assert\Valid]
    public ?SaveProductPromotionRequest $productPromotionRequest;

    #[Assert\When(
        expression: 'this.metaTitle !== null and this.metaTitle != ""',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $metaTitle;

    #[Assert\When(
        expression: 'this.metaDescription !== null and this.metaDescription != "" ',
        constraints: [
            new Assert\Length(min: 2, max: 500),
        ]
    )]
    public ?string $metaDescription;

    /**
     * @param array<int, mixed> $categories
     * @param array<int, mixed> $tags
     * @param array<int,mixed> $images
     * @param array<string, mixed> $attributes
     */
    public function __construct(
        ?int $id,
        string $name,
        string $regularPrice,
        array $stocks,
        string|int|null $mainCategoryId,
        mixed $isActive,
        mixed $promotionIsActive,
        ?string $promotionReductionType,
        ?string $promotionReduction,
        ?array $promotionDateRange,
        ?string $promotionSource,
        array $categories = [],
        array $tags = [],
        array $images = [],
        array $attributes = [],
        string|int|null $brandId = null,
        ?string $slug = null,
        ?string $description = null,
        ?string $metaTitle = null,
        ?string $metaDescription = null,
    ) {
        $this->idRequest = new IdRequest($id);
        $this->name = $name;
        $this->regularPrice = $regularPrice;
        $this->stocks = $stocks;
        $this->mainCategoryIdRequest = new IdRequest($mainCategoryId);
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->categories = $categories;
        $this->tags = $tags;
        $this->attributes = $attributes;
        $this->brandIdRequest = new IdRequest($brandId);
        $this->slug = $slug;
        $this->description = $description;
        $this->metaTitle = $metaTitle;
        $this->images = $images;
        $this->metaDescription = $metaDescription;

        $promotionIsActive = BoolHelper::castOrFail($promotionIsActive, 'promotionIsActive');

        $this->productPromotionRequest = $promotionIsActive ? $this->createSaveProductPromotionRequest(
            promotionReductionType: $promotionReductionType,
            promotionReduction: $promotionReduction,
            promotionDateRange: $promotionDateRange,
            promotionSource: $promotionSource,
        ) : null;
    }

    private function createSaveProductPromotionRequest(
        ?string $promotionReductionType,
        ?string $promotionReduction,
        array $promotionDateRange,
        ?string $promotionSource,
    ): SaveProductPromotionRequest {
        return new SaveProductPromotionRequest(
            isActive: true,
            reductionType: $promotionReductionType,
            reduction: $promotionReduction,
            startDate: new DateVO($promotionDateRange ? $promotionDateRange[0] : ''),
            endDate: new DateVO($promotionDateRange ? $promotionDateRange[1] : ''),
            source: $promotionSource
        );
    }

//    public static function fromArray(array $data): ArrayHydratableInterface
//    {
////        $promotionIsActive = $data['promotionIsActive'] ?? false;
////        $productPromotionRequest = null;
////        if ($promotionIsActive) {
////            $promotionDateRange = $data['promotionDateRange'] ?? null;
////            $productPromotionRequest = new SaveProductPromotionRequest(
////                isActive: $promotionIsActive,
////                reductionType: $data['promotionReductionType'],
////                reduction: $data['promotionReduction'],
////                startDate: new DateVO($promotionDateRange ? $promotionDateRange[0] : ''),
////                endDate: new DateVO($promotionDateRange ? $promotionDateRange[1] : ''),
////                source: $data['promotionSource'] ?? null,
////            );
////        }
////
////        $images = $data['images'] ?? [];
////        if (!empty($images)) {
////            $saveProductImageCollection = [];
////            foreach ($images as $image) {
////                $id = $image['id'] ?? null;
////                if (null === $id) {
////                    $saveProductImageCollection[] = new SaveProductImageRequest(
////                        isThumbnail: $image['isThumbnail'] ?? false,
////                        uploadData: FileData::fromArray($image),
////                    );
////                } else {
////                    $saveProductImageCollection[] = new SaveProductImageRequest(
////                        fileId: $id,
////                        isThumbnail: $image['isThumbnail'] ?? false,
////                    );
////                }
////            }
////            $images = $saveProductImageCollection;
////        }
////
////        return new self(
////            id: $data['id'] ?? null,
////            name: $data['name'],
////            regularPrice: $data['regularPrice'],
////            stocks: $data['stocks'],
////            mainCategory: $data['mainCategoryId'],
////            isActive: $data['isActive'],
////            categories: $data['categories'],
////            tags: $data['tags'],
////            images: $images,
////            attributes: $data['attributes'],
////            brand: $data['brandId'],
////            slug: $data['slug'],
////            description: $data['description'],
////            productPromotionRequest: $productPromotionRequest,
////            metaTitle: $data['metaTitle'] ?? null,
////            metaDescription: $data['metaDescription'] ?? null,
////        );
//    }
}
